<?php

interface InstituicaoDAO {

    public function listar();

    public function getByID($IDInstituicao);
    
    public function getMediaGeral($IDInstituicao);
}
