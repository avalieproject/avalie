<?php

class Unidade {

    private $IDUnidade;
    private $IDInstituicao;
    private $StNome;
    private $StEndereco;
    private $StTel1;
    private $StTel2;
    private $BlFoto;

    public function __construct($ArUnidade = array()) {
        if ($ArUnidade)
            Configurator::configure($this, $ArUnidade);
    }

    public function getIDUnidade() {
        return $this->IDUnidade;
    }

    public function getIDInstituicao() {
        return $this->IDInstituicao;
    }

    public function getStNome() {
        return $this->StNome;
    }

    public function getStEndereco() {
        return $this->StEndereco;
    }

    public function getStTel1() {
        return $this->StTel1;
    }

    public function getStTel2() {
        return $this->StTel2;
    }

    public function getBlFoto() {
        return $this->BlFoto;
    }

    public function setIDUnidade($IDUnidade) {
        $this->IDUnidade = $IDUnidade;
    }

    public function setIDInstituicao($IDInstituicao) {
        $this->IDInstituicao = $IDInstituicao;
    }

    public function setStNome($StNome) {
        $this->StNome = $StNome;
    }

    public function setStEndereco($StEndereco) {
        $this->StEndereco = $StEndereco;
    }

    public function setStTel1($StTel1) {
        $this->StTel1 = $StTel1;
    }

    public function setStTel2($StTel2) {
        $this->StTel2 = $StTel2;
    }

    public function setBlFoto($BlFoto) {
        $this->BlFoto = $BlFoto;
    }

}
