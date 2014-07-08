<?php

class IndexController extends Controller {

    public function index_action() {
        $InstituicaoModel = new InstituicaoModel();
        $ArMelhoresInstituicoesSuperior = $InstituicaoModel->listarMelhoresInstituicoesSuperior();
        $ArMelhoresInstituicoesTec = $InstituicaoModel->listarMelhoresInstituicoesTecnico();

        $this->view->addData('ArMelhoresInstituicoes', $ArMelhoresInstituicoesSuperior);
        $this->view->addData('ArMelhoresInstituicoesTec', $ArMelhoresInstituicoesTec);
    }

}
