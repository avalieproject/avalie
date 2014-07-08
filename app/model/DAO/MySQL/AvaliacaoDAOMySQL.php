<?php

class AvaliacaoDAOMySQL implements AvaliacaoDAO {

    private $db;

    public function __construct() {
        $this->db = Registry::getInstance()->get('DATABASE');
    }

    public function criar(Avaliacao $Avaliacao) {
        try {
            $StSQL = "INSERT INTO
                    Avaliacao (`IDAvaliacao` ,`IDInstituicao` ,`IDUsuario` ,`DtData`)
                  VALUES
                    (NULL , {$Avaliacao->getIDInstituicao()}, {$Avaliacao->getIDUsuario()}, date(NOW()))";
            $this->db->exec($StSQL);
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            throw new Exception('Erro ao criar avaliação.');
        }
    }

    public function criarQuestaoAvaliada($IDAvaliacao, $IDQuestao, $ItNota) {
        try {
            $StSQL = "INSERT INTO
                        AvaliacaoQuestao(`IDAvaliacao` ,`IDQuestao` ,`ItNota`)
                      VALUES
                        ({$IDAvaliacao}, {$IDQuestao}, {$ItNota})";
            return $this->db->exec($StSQL);
        } catch (Exception $e) {
            throw new Exception('Erro ao criar questões avaliadas.');
        }
    }

    public function getAvaliacao() {
        
    }

    public function getByIDUsuario($IDUsuario) {
        try {
            $ArAvaliacoesList = array();
            $StSQL = "SELECT
                        a.*, i.StNome as StInstituicao
                      FROM
                        Avaliacao a
                      LEFT JOIN
                        Instituicao i ON i.IDInstituicao = a.IDInstituicao
                      WHERE
                        a.IDUsuario = {$IDUsuario}";
            $this->db->query($StSQL);
            $ArAvaliacoes = $this->db->getResult();
            foreach ($ArAvaliacoes as $ArAvaliacao) {
                $ArAvaliacoesList[] = new Avaliacao($ArAvaliacao);
            }
            return $ArAvaliacoesList;
        } catch (Exception $e) {
            throw new Exception('Erro ao obter avaliações do usuário.');
        }
    }

    public function excluirAvaliacao($IDAvaliacao) {
        try {
            $StSQL = "DELETE FROM
                        Avaliacao
                      WHERE
                        IDAvaliacao = '$IDAvaliacao'";
            return $this->db->exec($StSQL);
        } catch (Exception $e) {
            throw new Exception('Erro ao excluir avaliação.');
        }
    }

    public function existeAvaliacao($IDUsuario, $IDInstituicao) {
        try {
            $StSQL = "SELECT
                        IDAvaliacao
                      FROM
                        Avaliacao
                      WHERE
                        IDUsuario = {$IDUsuario} AND IDInstituicao = {$IDInstituicao}";
            $this->db->query($StSQL);
            $ArAvaliacao = $this->db->getResult('row');
            if ($ArAvaliacao) {
                return $ArAvaliacao['IDAvaliacao'];
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception('Erro ao verificar existencia da avaliação.');
        }
    }

}
