<?php

class UsuarioController extends Controller {

    public function index_action() {
        
    }

    public function cadastrar() {
        $this->view->defaultCSS = array('usuario-cadastrar.css');
        $this->view->BoFullContent = false;
    }

    public function xhrCadastrarSubmit() {
        try {
            $ArUsuario = $_POST['ArUsuario'];
            $UsuarioModel = new UsuarioModel();
            $IDUsuario = $UsuarioModel->cadastrar($ArUsuario);
            if ($IDUsuario) {
                Message::geraSucesso('Usuário cadastrado com sucesso. Para fazer seu login acesse o link login no topo.');
                $ArReturn = array('StMsg' => 'Usuário criado com sucesso.', 'StType' => 'true');
            }
        } catch (Exception $e) {
            $ArReturn = array('StMsg' => $e->getMessage(), 'StType' => 'false');
        }
        die('(' . json_encode($ArReturn) . ')');
    }

    public function perfil() {

    }

    public function editarPerfil() {
        if ($this->request->isPost()) {
            $ArUsuario = $_POST['ArUsuario'];
            $ArUsuario['IDUsuario'] = Session::get('Usuario')->getIDUsuario();

            $UsuarioModel = new UsuarioModel();
            if ($UsuarioModel->editar($ArUsuario)) {
                Message::setMessage('Seu perfil foi editado com sucesso.', true);
                $Usuario = new Usuario($ArUsuario);
                Session::set('Usuario', $Usuario);
            }
            $this->redirect->goToControllerAction('usuario', 'perfil');
        }
    }

    public function avaliacoes() {
        $Usuario = Session::get('Usuario');
        $AvaliacaoModel = new AvaliacaoModel();
        $ArAvaliacoes = $AvaliacaoModel->getByIDUsuario($Usuario->getIDUsuario());
        $this->view->addData('ArAvaliacoes', $ArAvaliacoes);
    }

    
    public function instituicoes(){
        $Usuario = Session::get('Usuario');
        $InstituicaoModel = new InstituicaoModel();
        $ArInstituicoes = $InstituicaoModel->getByUsuario($Usuario->getIDUsuario());
        $this->view->addData('ArInstituicoes', $ArInstituicoes);
    }

}
