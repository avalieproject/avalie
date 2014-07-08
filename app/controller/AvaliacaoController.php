<?php

class AvaliacaoController extends Controller {

    public function excluirAvaliacao() {
        $IDAvaliacao = $this->getParam('id');
        $AvaliacaoModel = new AvaliacaoModel();
        if ($AvaliacaoModel->excluir($IDAvaliacao)) {
            Message::setMessage('A avaliação foi excluída com sucesso.', true);
        }
        $this->redirect->goToControllerAction('usuario', 'avaliacoes');
    }

    public function avaliarSubmit() {
        $Usuario = Session::get('Usuario');
        $ArAvaliacao = array_filter($_POST['ArAvaliacao']);
        $IDInstituicao = $_POST['IDInstituicao'];

        $AvaliacaoModel = new AvaliacaoModel();
        $IDAvaliacao = $AvaliacaoModel->existeAvaliacao($Usuario->getIDUsuario(), $IDInstituicao);
        if ($IDAvaliacao) {
            $AvaliacaoModel->excluirTodasQuestoesDeAvaliacao($IDAvaliacao);
        } else {
            $IDAvaliacao = $AvaliacaoModel->criar($IDInstituicao, $Usuario->getIDUsuario());
        }
        $AvaliacaoModel->registrarListaDeQuestoes($IDAvaliacao, $ArAvaliacao);

        Message::geraSucesso('Sua avaliação foi registrada com sucesso. Você poderá atualizar suas avaliações e também excluí-las através do seu perfil.');
        $this->redirect->setUrlParameter('id', $IDInstituicao);
        $this->redirect->goToControllerAction('instituicao', 'perfil');
    }

}
