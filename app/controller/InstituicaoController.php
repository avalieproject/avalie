<?php

class InstituicaoController extends Controller {

    public function index_action() {
        
    }

    public function perfil() {
        $IDInstituicao = $this->getParam('id');
        $InstituicaoModel = new InstituicaoModel();
        $Instituicao = $InstituicaoModel->getById($IDInstituicao);

        $this->view->addData('Instituicao', $Instituicao);
    }

    public function listar() {
        $StTipo = $this->getParam('t');
        
        $InstituicaModel = new InstituicaoModel();
        $ArInstituicoes = $InstituicaModel->listar($StTipo);

        $this->view->addData('ArInstituicoes', $ArInstituicoes);
    }

    public function avaliar() {
        $IDInstituicao = $this->getParam('id');
        $InstituicaoModel = new InstituicaoModel();
        $Instituicao = $InstituicaoModel->getById($IDInstituicao);
        $Usuario = Session::get('Usuario');

        if (!$InstituicaoModel->existeAssociacaoComUsuario($IDInstituicao, $Usuario->getIDUsuario())) {
            Message::geraAviso(sprintf(PRECISA_ASSOCIAR, $Instituicao->getStNome(), URL_AVALIE, $Instituicao->getIDInstituicao(), $Usuario->getIDUsuario()));
            $this->redirect->setUrlParameter('id', $IDInstituicao);
            $this->redirect->goToControllerAction('instituicao', 'perfil');
        }

        $AvaliacaoModel = new AvaliacaoModel();
        $IDAvaliacao = $AvaliacaoModel->existeAvaliacao($Usuario->getIDUsuario(), $IDInstituicao);
        if ($IDAvaliacao) {
            Message::geraAviso(sprintf(EXISTE_AVALIACAO, $Instituicao->getStNome(), URL_AVALIE, $Instituicao->getIDInstituicao(), $Usuario->getIDUsuario()));
            $ArQuestoesRespondidas = $AvaliacaoModel->getTodasRespostasDeAvaliacao($IDAvaliacao);

            $this->view->addData('ArQuestoesRespondidas', $ArQuestoesRespondidas);
        }

        $QuestaoModel = new QuestaoModel();
        $ArQuestoes = $QuestaoModel->listAll();

        $this->view->addData('Instituicao', $Instituicao);
        $this->view->addData('ArQuestoesPorConceitos', $ArQuestoes);
    }

    public function associar() {
        $IDInstituicao = $this->getParam('id');
        $IDUsuario = $this->getParam('idu');
        $InstituicaoModel = new InstituicaoModel();

        $this->redirect->setUrlParameter('id', $IDInstituicao);
        if ($InstituicaoModel->adicionaUsuarioAssociado($IDInstituicao, $IDUsuario)) {
            $this->redirect->goToControllerAction('instituicao', 'avaliar');
        } else {
            $this->redirect->goToControllerAction('instituicao', 'perfil');
        }
    }

    public function desassociar() {
        $IDInstituicao = $this->getParam('id');
        $IDUsuario = Session::get('Usuario')->getIDUsuario();

        $InstituicaoModel = new InstituicaoModel();
        $InstituicaoModel->removerUsuarioAssociado($IDInstituicao, $IDUsuario);
        
        $AvaliacaoModel = new AvaliacaoModel();
        $IDAvaliacao = $AvaliacaoModel->existeAvaliacao($IDUsuario, $IDInstituicao);
        if ($IDAvaliacao) {
            $AvaliacaoModel->excluir($IDAvaliacao);
        }

        Message::geraSucesso('Instituição removida com sucesso.');
        $this->redirect->goToControllerAction('usuario', 'instituicoes');
    }

}
