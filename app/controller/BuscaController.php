<?php

class BuscaController extends Controller {

    public function index_action() {
        $StBusca = !isset($_POST['StBusca']) ? false : $_POST['StBusca'];
       // var_dump($StBusca); die();
        if ($StBusca) {
            $InstituicaoModel = new InstituicaoModel();
            $ArInstituicoes = $InstituicaoModel->buscar($StBusca);
            $this->view->addData('ArInstituicoes', $ArInstituicoes);
        } else {
            $this->redirect->goToUrl(URL_AVALIE);
        }
    }

}
