<?php

class Controller extends Bootstrap {

    protected $request;
    protected $RequisicaoModel;
    protected $view;

    public function __construct() {
        parent::__construct();
        
        $this->request = new Requisicao($this->_controller, $this->_action);
        $this->view = new View();
    }

    public function init() {
        
    }

    public function finish() {
        $this->view->callView($this->_controller, $this->_action);
    }

}

?>
