<?php

class UnidadeModel {

    public function listByIDInstituicao($IDInstituicao) {
        Validar::ID($IDInstituicao, 'ID informado é inválido');
        $UnidadeDAO = DAOFactory::getDAO(DB_SYSTEM)->unidade();
        return $UnidadeDAO->listByInstituicao($IDInstituicao);
    }

}
