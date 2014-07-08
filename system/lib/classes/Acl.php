<?php

class Acl {

    private $StController;
    private $StAction;

    public function __construct($StController, $StAction) {
        $this->StController = strtolower($StController);
        $this->StAction = strtolower($StAction);
    }

    public function checkAutentication() {
        if (!$this->userAuth() && $this->searchActionInArray()) {
            Message::geraAviso('Para acessar esta página é preciso estar autenticado.'
                    . ' Caso não possua um cadastro acesse o link de cadastro no topo da página.');
            $redirect = new Redirector();
            $redirect->goBack();
        }
    }

    private function userAuth() {
        if (Session::check('Usuario')) {
            return true;
        } else {
            return false;
        }
    }

    private function searchActionInArray() {
        $ArActionsMap = $this->getAuthActions();
        if (array_key_exists($this->StController, $ArActionsMap)) {
            if (in_array($this->StAction, $ArActionsMap[$this->StController])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function getAuthActions() {
        return array(
            'usuario' => array(
                'perfil', 'avaliacoes', 'instituicoes', 'editarperfil'
            ),
            'instituicao' => array(
                'avaliar', 'desassociar', 'associar' 
            )
        );
    }

}
