<?php

/**
 * Classe de redirecionamento
 * 
 */
class Redirector {

    protected $StController;
    protected $StAction;
    protected $cachedRedirect;
    protected $parameters = array();

    /**
     * Executa um redirecionamento e encerra processamento.
     */
    protected function go($StData) {
        header("Location: " . URL_AVALIE . $StData);
        exit();
    }

    /**
     * Retorna a controller atual.
     */
    protected function getCurrentController() {
        global $Bootstrap;
        return $Bootstrap->_controller;
    }

    /**
     * Adiciona um parametro que será incluido na url no momento do redirecionamento.
     * Ex: NomedoParametro/Valor
     */
    public function setUrlParameter($StName, $StValue) {
        $this->parameters[$StName] = $StValue;
    }

    /**
     * Monta os parametros adicionados no formato necessário para a url.
     * Ex : param/valor
     */
    public function getUrlParameters() {
        $StParams = '';
        foreach ($this->parameters as $StName => $StValue)
            $StParams .= $StName . '/' . $StValue . '/';

        return $StParams;
    }

    /**
     * Executa o redirecionamento para uma controller informada.
     */
    public function goToController($StController) {
        $this->go($StController . '/index/' . $this->getUrlParameters());
    }

    /**
     * Executa o redirecionamento para uma action informada da controller atual.
     */
    public function goToAction($StAction) {
        $this->go($this->getCurrentController() . '/' . $StAction . '/' . $this->getUrlParameters());
    }

    /**
     * Executa o redirecionamento para uma controller especificando a action.
     */
    public function goToControllerAction($StController, $StAction) {
        $this->go($StController . '/' . $StAction . '/' . $this->getUrlParameters());
    }

    /**
     * Redireciona para a index.
     */
    public function goToIndex() {
        $this->go('');
    }

    /**
     * Redireciona para uma controller, sem passar action, caindo sempre na index. 
     */
    public function goController($StController) {
        $this->go($StController);
    }

    /**
     * Guarda o nome de uma controller e uma action, para o redirecionamento
     * ser feito depois pelo método redirect.
     */
    public function setControllerAction($StController, $StAction = null) {
        $this->StController = $StController;
        $this->StAction = $StAction;
        $this->cachedRedirect = true;
    }

    /**
     * Executa o redirecionamento para uma controller/action previamente definidas
     * pelo método setControllerAction().
     */
    public function redirect() {
        if ($this->cachedRedirect)
            $this->go($this->StController . '/' . $this->StAction . '/' . $this->getUrlParameters());
    }

    /**
     * Executa redirecionamento para uma url qualquer.
     */
    public function goToUrl($StUrl) {
        header("Location: " . $StUrl);
        exit();
    }
    
    public function goBack(){
        echo '<script>window.history.back();</script>';
        exit();
    }

}

?>
