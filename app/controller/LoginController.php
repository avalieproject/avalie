<?php

class LoginController extends Controller {

    public function index_action() {
        $this->view->defaultCSS = array('usuario-cadastrar.css');
        $this->view->BoFullContent = false;
    }

    public function xhrAutenticar() {
        $ArUsuario = $_POST['ArUsuario'];
        $UsuarioModel = new UsuarioModel();
        try {
            if ($UsuarioModel->autenticar($ArUsuario)) {
                $Usuario = $UsuarioModel->getByEmail($ArUsuario['StEmail']);
                $UsuarioModel->criaSessao($Usuario);
                $ArJsonReturn = array('StMsg' => 'Login efetuado com sucesso.', 'StType' => 'true');
                Message::setMessage('Login efetuado com sucesso.', true);
            } else {
                $ArJsonReturn = array('StMsg' => 'O e-mail ou a senha inseridos estão incorretos.', 'StType' => 'false');
            }
        } catch (Exception $e) {
            $ArJsonReturn = array('StMsg' => $e->getMessage(), 'StType' => 'false');
        }
        die('(' . json_encode($ArJsonReturn) . ')');
    }

    public function logout() {
        Session::destroy();
        $this->redirect->goToUrl(URL_AVALIE);
    }

}
