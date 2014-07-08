<?php

class Usuario {

    private $IDUsuario;
    private $StEmail;
    private $StSenha;
    private $StNome;
    private $EnConfirmado;
    private $ArInstituicoes;
    private $ArAvaliacoes;

    public function __construct($ArUsuario = array()) {
        if ($ArUsuario) {
            Configurator::configure($this, $ArUsuario);
        }
    }

    public function getIDUsuario() {
        return $this->IDUsuario;
    }

    public function getStEmail() {
        return $this->StEmail;
    }

    public function getStSenha() {
        return $this->StSenha;
    }

    public function getStNome() {
        return $this->StNome;
    }

    public function getEnConfirmado() {
        return $this->EnConfirmado;
    }

    public function getArInstituicoes() {
        return $this->ArInstituicoes;
    }

    public function getArAvaliacoes() {
        return $this->ArAvaliacoes;
    }

    public function setIDUsuario($IDUsuario) {
        $this->IDUsuario = $IDUsuario;
    }

    public function setStEmail($StEmail) {
        $this->StEmail = $StEmail;
    }

    public function setStSenha($StSenha) {
        $this->StSenha = $StSenha;
    }

    public function setStNome($StNome) {
        $this->StNome = $StNome;
    }

    public function setEnConfirmado($EnConfirmado) {
        $this->EnConfirmado = $EnConfirmado;
    }

    public function setArInstituicoes($ArInstituicoes) {
        $this->ArInstituicoes = $ArInstituicoes;
    }

    public function setArAvaliacoes($ArAvaliacoes) {
        $this->ArAvaliacoes = $ArAvaliacoes;
    }

}
