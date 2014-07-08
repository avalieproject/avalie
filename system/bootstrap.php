<?php

class Bootstrap {

    private $_url;
    private $_explode;
    public $_controller;
    public $_action;
    public $_params;
    public $redirect;

    public function __construct() {
        $this->setUrl();
        $this->setExplode();
        $this->setController();
        $this->setAction();
        $this->setParams();
        $this->redirect = new Redirector();
    }

    private function setUrl() {
        $_GET['url'] = (isset($_GET['url']) ? $_GET['url'] : 'index/index_action');
        $this->_url = $_GET['url'];
    }

    private function setExplode() {
        $this->_explode = explode('/', $this->_url);
    }

    private function setController() {
        $this->_controller = ucfirst($this->_explode[0]);
    }

    private function setAction() {
        $ac = (!isset($this->_explode[1]) || $this->_explode[1] == null || $this->_explode[1] == 'index' ? 'index_action' : $this->_explode[1]);
        $this->_action = $ac;
    }

    private function setParams() {
        $value = array();
        unset($this->_explode[0], $this->_explode[1]);

        if (end($this->_explode) == null) {
            array_pop($this->_explode);
        }

        $i = 0;
        if (!empty($this->_explode)) {
            foreach ($this->_explode as $val) {
                if ($i % 2 == 0) {
                    $ind[] = $val;
                } else {
                    $value[] = $val;
                }
                $i++;
            }
        } else {
            $ind = array();
            $value = array();
        }

        if (count($ind) == count($value) && !empty($ind) && !empty($value))
            $this->_params = array_combine($ind, $value);
        else
            $this->_params = array();
    }

    public function getParam($name = null) {
        if ($name != null) {
            if (isset($this->_params[$name]))
                return $this->_params[$name];
            else
                return false;
        } else
            return $this->_params;
    }

    public function run() {
        $controller_path = CONTROLLERS . $this->_controller . 'Controller.php';

        if (!file_exists($controller_path)) {
            $this->redirect->goToUrl(URL_404);
        }


        require_once ($controller_path);
        $StController = $this->_controller . 'Controller';
        $app = new $StController;

        if (!method_exists($app, $this->_action)) {
            if ($this->_controller == 'Login') {
                $StConta = $this->_action;
                $app->index_action($StConta);
                exit();
            } else {
                $this->redirect->goController('404');
            }
        }

        $Acl = new Acl($this->_controller, $this->_action);
        $Acl->checkAutentication();

        $action = $this->_action;
        $app->init();
        $app->$action();
        $app->finish();
    }

}

?>
