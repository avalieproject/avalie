<?php

class Requisicao {

    private $BoAutenticacao;
    private $StOpcao;
    private $StAcao;

    public function __construct($StOpcao = null, $StAcao = null) {
        $this->StOpcao = strtolower($StOpcao);
        $this->StAcao = strtolower($StAcao);
    }

    public function validaRequisicao($BoAutenticacao, $BoSomenteAdmin = false) {
        
    }

    private function validaAutenticacao() {
        if (!Session::check('Usuario')) {
            Session::destroy();
            return false;
        } else
            return true;
    }

    public function isPost() {
        return ($_SERVER['REQUEST_METHOD'] == 'POST');
    }

    public function getPost($StInd) {
        if (isset($_POST[$StInd]))
            return $_POST[$StInd];
        else
            return null;
    }

}

?>
