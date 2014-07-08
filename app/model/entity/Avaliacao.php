<?php

class Avaliacao {

    private $IDAvaliacao;
    private $IDUsuario;
    private $IDInstituicao;
    private $DtData;
    private $ArQuestoes;
    private $StInstituicao;

    public function __construct($ArAvaliacao = array()) {
        if ($ArAvaliacao) {
            Configurator::configure($this, $ArAvaliacao);
        }
    }

    public function getIDAvaliacao() {
        return $this->IDAvaliacao;
    }

    public function getIDUsuario() {
        return $this->IDUsuario;
    }

    public function getIDInstituicao() {
        return $this->IDInstituicao;
    }

    public function getDtData() {
        return $this->DtData;
    }

    public function getArQuestoes() {
        return $this->ArQuestoes;
    }

    public function getStInstituicao() {
        return $this->StInstituicao;
    }

    public function setIDAvaliacao($IDAvaliacao) {
        $this->IDAvaliacao = $IDAvaliacao;
    }

    public function setIDUsuario($IDUsuario) {
        $this->IDUsuario = $IDUsuario;
    }

    public function setIDInstituicao($IDInstituicao) {
        $this->IDInstituicao = $IDInstituicao;
    }

    public function setDtData($DtData) {
        $this->DtData = $DtData;
    }

    public function setArQuestoes($ArQuestoes) {
        $this->ArQuestoes = $ArQuestoes;
    }

    public function setStInstituicao($StInstituicao) {
        $this->StInstituicao = $StInstituicao;
    }

}
