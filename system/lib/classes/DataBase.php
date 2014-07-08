<?php

/**
 * DataBase
 *  
 * @author Vitor Sekiguchi <vitor@hostnet.com.br>
 */
class DataBase {

    const TABLE_ULTRASUITE = 'UltraSuite';
    const TABLE_CORPORATE = 'Corporate';
    const TABLE_DEPTO = 'Depto';
    const TABLE_GRUPO = 'Grupo';
    const TABLE_MODULO = 'Modulo';
    const TABLE_FUNC = 'Funcionario';
    const TABLE_USER = 'Usuario';
    const TABLE_OPCAO = 'Opcao';
    const TABLE_LOG = 'Log';
    const TABLE_PERMISSAO_GRUPO = 'PermissaoGrupo';
    const TABLE_PERMISSAO_USUARIO = 'PermissaoUsuario';
    const TABLE_GRUPO_USUARIO = 'GrupoUsuario';
    const TABLE_DEPTO_FUNC = 'DeptoFuncionario';
    const TABLE_TROCA_SENHA = 'TrocaSenha';

    private $PDOInstance;
    private $QueryRs;

    public function __construct($StHost, $StBase, $StUser, $StPass) {
        try {
            $this->PDOInstance = new PDO('mysql:host=' . $StHost . ';dbname=' . $StBase, $StUser, $StPass);
            $this->PDOInstance->exec('SET NAMES UTF8');
            $this->PDOInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception('Não foi possível conectar com o banco de dados.');
        }
    }

    public function prepare($StSQL) {
        return $this->PDOInstance->prepare($StSQL);
    }

    /**
     * Executa uma query e retorna o numero de affected rows
     * 
     * @param String $StSql Comando SQL
     */
    public function exec($StSql) {
        return $this->PDOInstance->exec($StSql);
    }

    /**
     * Executa uma query e retorna um PDOStatement object
     * 
     * @param String $StSql Comando SQL
     * @return PDOStatement 
     */
    public function query($StSql) {
        $this->QueryRs = $this->PDOInstance->query($StSql);
    }

    /**
     * Retorna ultimo ID inserido 
     * 
     * @return String Ultimo ID inserido no banco
     */
    public function lastInsertId() {
        return $this->PDOInstance->lastInsertId();
    }

    /**
     * Retorna algum atributo da conexão atual
     * 
     * @param int $ItAttribute
     * @return mixed
     */
    public function getAttribute($ItAttribute) {
        return $this->PDOInstance->getAttribute($ItAttribute);
    }

    /**
     * Caso tenhamos em mãos um retorno de uma query, podemos
     * buscar o resultado por aqui.
     * 
     * @param String $StFetch Maneira como desejamos que o retorno seja organizado
     * 
     * @return Array Organizado da maneira escolhida pelo parametro FetchMode
     */
    public function getResult($StFetch = 'all') {
        $this->QueryRs->setFetchMode(PDO::FETCH_ASSOC);
        if ($StFetch == 'all')
            return $this->QueryRs->fetchAll();
        else if ($StFetch == 'row')
            return $this->QueryRs->fetch();
    }

    public function insert($StTabela, $ArDados) {
        $ArDados = is_object($ArDados) ? $ArDados->toArray(false) : $ArDados;

        $StIndSQL = implode(', ', array_keys($ArDados));
        $StParamsSQL = implode(', :', array_keys($ArDados));

        $StSQL = "INSERT INTO {$StTabela} ({$StIndSQL}) VALUES (:{$StParamsSQL})";
        $stmt = $this->prepare($StSQL);

        foreach ($ArDados as $StProp => $StPropValue) {
            if (is_int($StPropValue))
                $paramType = PDO::PARAM_INT;
            else if (is_bool($StPropValue))
                $paramType = PDO::PARAM_BOOL;
            else if (is_null($StPropValue))
                $paramType = PDO::PARAM_NULL;
            else if (is_string($StPropValue))
                $paramType = PDO::PARAM_STR;
            else
                $paramType = FALSE;

            $stmt->bindValue(":{$StProp}", $StPropValue, $paramType);
        }

        if ($stmt->execute()) {
            if ($this->lastInsertId())
                return $this->lastInsertId();
            else
                return true;
        } else
            return false;
    }

    public function delete($StTabela, $ArWhere) {
        $ArWhere = is_object($ArWhere) ? $ArWhere->toArray(false) : $ArWhere;
        $ArCondicoes = array();

        $StSQL = "DELETE FROM {$StTabela} WHERE ";

        foreach ($ArWhere as $coluna => $valor)
            $ArCondicoes[] = "{$coluna} = '{$valor}'";

        $StSQL .= implode(' AND ', $ArCondicoes);

        $stmt = $this->prepare($StSQL);
        if ($stmt->execute())
            return true;
        else
            return false;
    }

    public function select($StTabela, $ArColunas = null, $ArWhere = null, $fetch = 'all', $ItLimit = null, $StOrder = null) {
        $ArWhere = is_object($ArWhere) ? $ArWhere->toArray(false) : $ArWhere;
        $ArCondicoes = array();

        if (!is_null($ArColunas) && is_array($ArColunas))
            $StColunas = implode(', ', $ArColunas);
        else
            $StColunas = '*';

        $StSQL = "SELECT {$StColunas} FROM {$StTabela} ";

        if (!is_null($ArWhere) && is_array($ArWhere)) {
            foreach ($ArWhere as $coluna => $valor) {
                $ArCondicoes[] = "{$coluna} = '{$valor}'";
            }
            $StSQL .= ' WHERE ' . implode(' AND ', $ArCondicoes);
        }

        if ($StOrder)
            $StSQL .= " ORDER BY {$StOrder}";

        if (!is_null($ItLimit))
            $StSQL .= " LIMIT {$ItLimit}," . Pagination::LIMIT_TABLES;

        $stmt = $this->prepare($StSQL);

        if ($stmt->execute()) {
            if ($fetch == 'all')
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            else
                return $stmt->fetch(PDO::FETCH_ASSOC);
        } else
            return array();
    }

    public function update($StTabela, $ArWhere, $ArDados) {
        $ArDados = is_object($ArDados) ? $ArDados->toArray(false) : $ArDados;

        $ArCondicoes = array();
        $ArCampos = array();

        foreach ($ArDados as $coluna => $valor)
            $ArCampos[] = "{$coluna} = '{$valor}'";

        foreach ($ArWhere as $coluna => $valor)
            $ArCondicoes[] = "{$coluna} = '{$valor}'";

        $StSQL = "UPDATE {$StTabela} SET ";
        $StSQL .= implode(', ', $ArCampos);
        $StSQL .= ' WHERE ' . implode(' AND ', $ArCondicoes);

        $stmt = $this->prepare($StSQL);

        if ($stmt->execute())
            return true;
        else
            return false;
    }

}

?>
