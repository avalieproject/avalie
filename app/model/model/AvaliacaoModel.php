<?php

class AvaliacaoModel {

    public function criar($IDInstituicao, $IDUsuario) {
        Validar::ID($IDInstituicao, 'ID da instituicao é inválido.');
        Validar::ID($IDUsuario, 'ID do usuário é inválido.');

        $AvaliacaoDAO = DAOFactory::getDAO(DB_SYSTEM)->avaliacao();

        $Avaliacao = new Avaliacao(array('IDUsuario' => $IDUsuario, 'IDInstituicao' => $IDInstituicao));
        return $AvaliacaoDAO->criar($Avaliacao);
    }

    public function getByIDUsuario($IDUsuario) {
        Validar::ID($IDUsuario, 'ID informado é inválido.');

        $AvaliacaoDAO = DAOFactory::getDAO(DB_SYSTEM)->avaliacao();
        return $AvaliacaoDAO->getByIDUsuario($IDUsuario);
    }

    public function registrarListaDeQuestoes($IDAvaliacao, array $ArQuestoes) {
        foreach ($ArQuestoes as $IDQuestao => $ItNota) {
            $this->adicionarQuestaoAvaliada($IDAvaliacao, $IDQuestao, $ItNota);
        }
    }

    public function adicionarQuestaoAvaliada($IDAvaliacao, $IDQuestao, $ItNota) {
        $this->validarNota($ItNota);
        $AvaliacaoDAO = DAOFactory::getDAO(DB_SYSTEM)->avaliacao();
        return $AvaliacaoDAO->criarQuestaoAvaliada($IDAvaliacao, $IDQuestao, $ItNota);
    }

    private function validarNota($ItNota) {
        if ($ItNota < 1 || $ItNota > 5) {
            throw new Exception('Valor inválido para nota.');
        }
    }

    public function excluirTodasQuestoesDeAvaliacao($IDAvaliacao) {
        Validar::ID($IDAvaliacao, 'ID da avaliação é inválido.');
        $QuestaoDAO = DAOFactory::getDAO(DB_SYSTEM)->questao();
        return $QuestaoDAO->deletarTodasRespostas($IDAvaliacao);
    }

    public function getTodasRespostasDeAvaliacao($IDAvaliacao) {
        Validar::ID($IDAvaliacao, 'ID da avaliação é inválido.');
        $QuestaoDAO = DAOFactory::getDAO(DB_SYSTEM)->questao();
        return $QuestaoDAO->listaByAvaliacao($IDAvaliacao);
    }

    public function excluir($IDAvaliacao) {
        Validar::ID($IDAvaliacao, 'ID da avaliação é inválido.');
        $AvaliacaoDAO = DAOFactory::getDAO(DB_SYSTEM)->avaliacao();
        return $AvaliacaoDAO->excluirAvaliacao($IDAvaliacao);
    }

    public function existeAvaliacao($IDUsuario, $IDInstituicao) {
        Validar::ID($IDInstituicao, 'ID da instituicao é inválido.');
        Validar::ID($IDUsuario, 'ID do usuário é inválido.');
        $AvaliacaoDAO = DAOFactory::getDAO(DB_SYSTEM)->avaliacao();
        return $AvaliacaoDAO->existeAvaliacao($IDUsuario, $IDInstituicao);
    }

}
