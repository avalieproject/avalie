<?php

class InstituicaoDAOMySQL implements InstituicaoDAO {

    private $db;

    public function __construct() {
        $this->db = Registry::getInstance()->get('DATABASE');
    }

    public function listar($StTipo = 'SUPERIOR') {
        try {
            $StSQL = "SELECT
                        i . * , round( AVG( aq.ItNota ) , 1 ) AS FlMediaGeral
                      FROM
                        Instituicao i
                      LEFT JOIN Avaliacao a ON a.IDInstituicao = i.IDInstituicao
                      LEFT JOIN AvaliacaoQuestao aq ON a.IDAvaliacao = aq.IDAvaliacao
                      WHERE i.EnTipo = '{$StTipo}'
                      GROUP BY i.IDInstituicao
                      ORDER BY FlMediaGeral DESC 
                      LIMIT 0 , 10";
            $this->db->query($StSQL);
            $ArInstituicoes = $this->db->getResult();
            $ArInstituicoesList = array();
            foreach ($ArInstituicoes as $ArInstituicao) {
                $ArInstituicoesList[] = new Instituicao($ArInstituicao);
            }
            return $ArInstituicoesList;
        } catch (Exception $e) {
            echo $e->getMessage(); DIE();
            throw new Exception('Erro ao obter listagem:' . $e->getMessage());
        }
    }

    public function getByID($IDInstituicao) {
        try {
            $StSQL = "SELECT
                    i.*, COUNT(a.IDInstituicao) as ItTotalAvaliacoes
                  FROM
                    Instituicao i
                  LEFT JOIN
                    Avaliacao a ON a.IDInstituicao = i.IDInstituicao  
                  WHERE
                    i.IDinstituicao = " . $IDInstituicao;

            $this->db->query($StSQL);
            $ArInstituicao = $this->db->getResult('row');
            $Instituicao = new Instituicao($ArInstituicao);
            return $Instituicao;
        } catch (Exception $e) {
            throw new Exception('Erro ao obter instituicao.');
        }
    }

    public function getMediaGeral($IDInstituicao) {
        try {
            $StSQL = "SELECT
                        round(AVG(aq.ItNota),1) as FlMediaGeral
                      FROM
                        AvaliacaoQuestao aq
                      INNER JOIN
                        Avaliacao a ON a.IDAvaliacao = aq.IDAvaliacao
                      WHERE
                        a.IDInstituicao = " . $IDInstituicao;
            $this->db->query($StSQL);
            $ArResultado = $this->db->getResult('row');
            return $ArResultado['FlMediaGeral'];
        } catch (Exception $e) {
            throw new Exception('Erro ao obter media geral.');
        }
    }

    public function getMediaDetalhada($IDInstituicao) {
        try {
            $StSQL = "SELECT
                        c.StConceito, round( AVG( aq.ItNota ) , 1 ) AS FlMedia
                      FROM
                        AvaliacaoQuestao aq
                      LEFT JOIN
                        Avaliacao a ON a.IDAvaliacao = aq.IDAvaliacao
                      LEFT JOIN
                        Questao q ON q.IDQuestao = aq.IDQuestao
                      LEFT JOIN
                        Conceito c ON c.IDConceito = q.IDConceito
                      WHERE
                        a.IDInstituicao = {$IDInstituicao}
                      GROUP BY
                        q.IDConceito";

            $this->db->query($StSQL);
            $ArResultado = $this->db->getResult();
            return $ArResultado;
        } catch (Exception $e) {
            throw new Exception('Erro ao obter media detalhada.');
        }
    }

    public function listarMelhoresInstituicoes($StTipo = 'SUPERIOR') {
        try {
            $StSQL = "SELECT
                    i.*, round(AVG(aq.ItNota),1) as FlMediaGeral
                  FROM
                    AvaliacaoQuestao aq
                  RIGHT JOIN
                    Avaliacao a ON a.IDAvaliacao = aq.IDAvaliacao
                  RIGHT JOIN
                    Instituicao i ON i.IDInstituicao = a.IDInstituicao";

            if ($StTipo) {
                $StSQL .= " WHERE i.EnTipo = '{$StTipo}' ";
            }

            $StSQL .= " GROUP BY
                            i.IDInstituicao
                        ORDER BY 
                            FlMediaGeral DESC
                        LIMIT 0,3";
            $this->db->query($StSQL);
            $ArResultado = $this->db->getResult();
            foreach ($ArResultado as $ArInstituicao) {
                $ArListaInstituicoes[] = new Instituicao($ArInstituicao);
            }
            return $ArListaInstituicoes;
        } catch (Exception $e) {
            throw new Exception('Erro ao obter melhores instituicoes.');
        }
    }

    public function existeAssociacaoComUsuario($IDUsuario, $IDInstituicao) {
        try {
            $StSQL = "SELECT * FROM
                        InstituicaoUsuario
                      WHERE
                        IDInstituicao = {$IDInstituicao} AND IDUsuario = {$IDUsuario}";
            $this->db->query($StSQL);
            $ArResultado = $this->db->getResult('row');
            if ($ArResultado) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception('Erro ao buscar associacao.');
        }
    }

    public function relacionarUsuario($IDInstituicao, $IDUsuario) {
        try {
            $StSQL = "INSERT INTO 
                        InstituicaoUsuario (IDInstituicao, IDUsuario)
                      VALUES
                        ({$IDInstituicao}, {$IDUsuario})";
            if ($this->db->exec($StSQL)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception('Erro ao relacionar usuário e instituição.');
        }
    }

    public function desrelacionarUsuario($IDInstituicao, $IDUsuario) {
        try {
            $StSQL = "DELETE FROM
                        InstituicaoUsuario
                      WHERE
                        IDInstituicao = {$IDInstituicao} AND IDUsuario = {$IDUsuario}";
            if ($this->db->exec($StSQL)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception('Erro ao desrelacionar usuário e instituição.');
        }
    }

    public function getByIDUsuario($IDUsuario) {
        try {
            $ArInstituicoesList = array();
            $StSQL = "SELECT
                        i.*
                      FROM
                        Instituicao i
                      LEFT JOIN
                        InstituicaoUsuario iu ON iu.IDInstituicao = i.IDInstituicao
                      WHERE
                        iu.IDUsuario = {$IDUsuario}";
            $this->db->query($StSQL);
            $ArResultado = $this->db->getResult();
            foreach ($ArResultado as $ArInstituicao) {
                $ArInstituicoesList[] = new Instituicao($ArInstituicao);
            }
            return $ArInstituicoesList;
        } catch (Exception $e) {
            throw new Exception('Erro ao listar instituições por usuário.');
        }
    }

    public function buscar($StBusca) {
        try {
            $ArInstituicoesList = array();
            $StSQL = "SELECT 
                        *
                      FROM
                        Instituicao
                      WHERE
                        StNome LIKE '%{$StBusca}%'
                      ORDER BY
                        StNome";
            $this->db->query($StSQL);
            $ArResultado = $this->db->getResult();
            foreach ($ArResultado as $ArInstituicao) {
                $ArInstituicoesList[] = new Instituicao($ArInstituicao);
            }
            return $ArInstituicoesList;
        } catch (Exception $e) {
            throw new Exception('Erro ao buscar instituições.');
        }
    }

}
