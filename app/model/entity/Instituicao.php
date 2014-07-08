<?php

class Instituicao {

    private $IDInstituicao;
    private $StNome;
    private $EnTipo;
    private $BlLogo;
    private $DtCadastro;
    private $ArMediaDetalhada;
    private $FlMediaGeral;
    private $ItTotalAvaliacoes;
    private $ArUnidades;
    private $ItMec;

    public function __construct($ArInstituicao = array()) {
        if ($ArInstituicao)
            Configurator::configure($this, $ArInstituicao);
    }

    public function getIDInstituicao() {
        return $this->IDInstituicao;
    }

    public function getStNome() {
        return $this->StNome;
    }

    public function getEnTipo() {
        return $this->EnTipo;
    }

    public function getBlLogo() {
        return $this->BlLogo;
    }

    public function getDtCadastro() {
        return $this->DtCadastro;
    }

    public function getArMediaDetalhada() {
        return $this->ArMediaDetalhada;
    }

    public function getFlMediaGeral() {
        return $this->FlMediaGeral;
    }

    public function getItTotalAvaliacoes() {
        return $this->ItTotalAvaliacoes;
    }

    public function getArUnidades() {
        return $this->ArUnidades;
    }

    public function getItMec() {
        return $this->ItMec;
    }

    public function setIDInstituicao($IDInstituicao) {
        $this->IDInstituicao = $IDInstituicao;
    }

    public function setStNome($StNome) {
        $this->StNome = $StNome;
    }

    public function setEnTipo($EnTipo) {
        $this->EnTipo = $EnTipo;
    }

    public function setBlLogo($BlLogo) {
        $this->BlLogo = $BlLogo;
    }

    public function setDtCadastro($DtCadastro) {
        $this->DtCadastro = $DtCadastro;
    }

    public function setArMediaDetalhada($ArMediaDetalhada) {
        $this->ArMediaDetalhada = $ArMediaDetalhada;
    }

    public function setFlMediaGeral($FlMediaGeral) {
        $this->FlMediaGeral = $FlMediaGeral;
    }

    public function setItTotalAvaliacoes($ItTotalAvaliacoes) {
        $this->ItTotalAvaliacoes = $ItTotalAvaliacoes;
    }

    public function setArUnidades($ArUnidades) {
        $this->ArUnidades = $ArUnidades;
    }

    public function setItMec($ItMec) {
        $this->ItMec = $ItMec;
    }

    public function isSuperior() {
        if ($this->EnTipo == 'SUPERIOR') {
            return true;
        } else {
            return false;
        }
    }

}
