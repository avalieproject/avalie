<?php

class QuestaoDAOMySQL implements QuestaoDAO {

    private $db;

    public function __construct() {
        $this->db = Registry::getInstance()->get('DATABASE');
    }

    public function listAll() {
        try {
            $ArQuestoesPorConceitos = array();
            $StSQL = "SELECT  
                        q.*, c.StConceito
                      FROM
                        Questao q
                      LEFT JOIN Conceito c ON c.IDConceito = q.IDConceito";
            $this->db->query($StSQL);
            $ArQuestoes = $this->db->getResult();
            foreach ($ArQuestoes as $ArQuestao) {
                $ArQuestoesPorConceitos[$ArQuestao['StConceito']][] = new Questao($ArQuestao);
            }
            return $ArQuestoesPorConceitos;
        } catch (Exception $e) {
            throw new Exception('Erro ao obter questões.');
        }
    }

    public function listaByAvaliacao($IDAvaliacao) {
        try {
            $StSQL = "SELECT
                        *
                      FROM
                        AvaliacaoQuestao
                      WHERE 
                        IDAvaliacao = {$IDAvaliacao}";
            $this->db->query($StSQL);
            $ArQuestoes = $this->db->getResult();
            return $ArQuestoes;
        } catch (Exception $e) {
            throw new Exception('Erro ao obter questões da avaliação.');
        }
    }

    public function deletarTodasRespostas($IDAvaliacao) {
        try {
            $StSQL = "DELETE FROM
                        AvaliacaoQuestao
                      WHERE 
                        IDAvaliacao = {$IDAvaliacao}";
            return $this->db->exec($StSQL);
        } catch (Exception $e) {
            throw new Exception('Erro ao excluir respostas armazenadas.');
        }
    }

}
