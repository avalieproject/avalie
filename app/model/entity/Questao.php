<?php

class Questao {

    private $IDQuestao;
    private $IDConceito;
    private $StQuestao;

    public function __construct($ArQuestao = array()) {
        if ($ArQuestao) {
            Configurator::configure($this, $ArQuestao);
        }
    }

    public function getIDQuestao() {
        return $this->IDQuestao;
    }

    public function getIDConceito() {
        return $this->IDConceito;
    }

    public function getStQuestao() {
        return $this->StQuestao;
    }

    public function setIDQuestao($IDQuestao) {
        $this->IDQuestao = $IDQuestao;
    }

    public function setIDConceito($IDConceito) {
        $this->IDConceito = $IDConceito;
    }

    public function setStQuestao($StQuestao) {
        $this->StQuestao = $StQuestao;
    }

}
