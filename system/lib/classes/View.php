<?php

class View {

    public $ArData = array();
    public $defaultJS = array('jquery-1.5.1.min.js', 'jquery.orbit-1.2.3.js', 'JModal.js', 'avalie.js');
    public $defaultCSS = array('orbit-1.2.3.css', 'avalie.css');
    public $StTitle;
    public $BoFullContent = true;

    public function addData($StInd, $MxData) {
        $this->ArData[$StInd] = $MxData;
    }

    public function setTitle($StTitle) {
        $this->StTitle = $StTitle;
    }

    private function generateTitle($StController, $StAction) {
        if ($StController == 'Main')
            return '';

        if ($StAction == 'index_action')
            return strtolower($StController);

        return ' - ' . ucfirst(strtolower($StAction)) . ' ' . strtolower($StController);
    }

    public function callView($StController, $StAction) {
        if (empty($this->StTitle))
            $this->StTitle = $this->generateTitle($StController, $StAction);

        if (is_array($this->ArData) && count($this->ArData) > 0)
            extract($this->ArData, EXTR_PREFIX_ALL, '');

        if ($this->BoFullContent)
            require_once ( VIEWS . 'topo.phtml' );
        else
            require_once ( VIEWS . 'topo-vazio.phtml' );;

        require_once( VIEWS . strtolower($StController) . '/' . strtolower($StAction) . '.phtml' );

        if ($this->BoFullContent)
            require_once ( VIEWS . 'footer.phtml' );

        exit();
    }

}

?>
