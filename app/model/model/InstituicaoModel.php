<?php

class InstituicaoModel {

    public function listar($StTipo) {
        $InstituicaoDAO = DAOFactory::getDAO(DB_SYSTEM)->instituicao();
        return $InstituicaoDAO->listar($StTipo);
    }

    public function getById($IDInstituicao) {
        Validar::ID($IDInstituicao, 'ID informado é inválido');
        $InstituicaoDAO = DAOFactory::getDAO(DB_SYSTEM)->instituicao();
        $Instituicao = $InstituicaoDAO->getByID($IDInstituicao);

        $this->getMediaGeral($Instituicao);

        $ArMediaDetalhada = $this->getMediaDetalhada($IDInstituicao);
        $Instituicao->setArMediaDetalhada($ArMediaDetalhada);

        $UnidadeModel = new UnidadeModel();
        $ArUnidades = $UnidadeModel->listByIDInstituicao($IDInstituicao);
        $Instituicao->setArUnidades($ArUnidades);

        return $Instituicao;
    }

    public function getMediaDetalhada($IDInstituicao) {
        Validar::ID($IDInstituicao, 'ID informado é inválido');
        $InstituicaoDAO = DAOFactory::getDAO(DB_SYSTEM)->instituicao();
        return $InstituicaoDAO->getMediaDetalhada($IDInstituicao);
    }

    public function listarMelhoresInstituicoesSuperior() {
        $InstituicaoDAO = DAOFactory::getDAO(DB_SYSTEM)->instituicao();
        return $InstituicaoDAO->listarMelhoresInstituicoes();
    }

    public function listarMelhoresInstituicoesTecnico() {
        $InstituicaoDAO = DAOFactory::getDAO(DB_SYSTEM)->instituicao();
        return $InstituicaoDAO->listarMelhoresInstituicoes('TECNICO');
    }

    public function getMediaGeral(Instituicao $Instituicao) {
        Validar::ID($Instituicao->getIDInstituicao(), 'ID informado é inválido');
        $InstituicaoDAO = DAOFactory::getDAO(DB_SYSTEM)->instituicao();

        $FlMediaGeral = $InstituicaoDAO->getMediaGeral($Instituicao->getIDInstituicao());
        if ($Instituicao->isSuperior()) {
            $FlMediaGeral = (($FlMediaGeral + $Instituicao->getItMec()) / 2);
        }
        $Instituicao->setFlMediaGeral($FlMediaGeral);
    }

    public function existeAssociacaoComUsuario($IDInstituicao, $IDUsuario) {
        Validar::ID($IDInstituicao, 'ID informado é inválido');
        Validar::ID($IDUsuario, 'ID informado é inválido');
        $InstituicaoDAO = DAOFactory::getDAO(DB_SYSTEM)->instituicao();
        return $InstituicaoDAO->existeAssociacaoComUsuario($IDUsuario, $IDInstituicao);
    }

    public function adicionaUsuarioAssociado($IDInstituicao, $IDUsuario) {
        Validar::ID($IDInstituicao, 'ID informado é inválido');
        Validar::ID($IDUsuario, 'ID informado é inválido');
        $InstituicaoDAO = DAOFactory::getDAO(DB_SYSTEM)->instituicao();
        return $InstituicaoDAO->relacionarUsuario($IDInstituicao, $IDUsuario);
    }

    public function removerUsuarioAssociado($IDInstituicao, $IDUsuario) {
        Validar::ID($IDInstituicao, 'ID da instituicao é inválido.');
        Validar::ID($IDUsuario, 'ID da instituicao é inválido.');
        $InstituicaoDAO = DAOFactory::getDAO(DB_SYSTEM)->instituicao();
        return $InstituicaoDAO->desrelacionarUsuario($IDInstituicao, $IDUsuario);
    }

    public function getByUsuario($IDUsuario) {
        Validar::ID($IDUsuario, 'ID informado é inválido');
        $InstituicaoDAO = DAOFactory::getDAO(DB_SYSTEM)->instituicao();
        return $InstituicaoDAO->getByIDUsuario($IDUsuario);
    }

    public function buscar($StBusca) {
        $InstituicaoDAO = DAOFactory::getDAO(DB_SYSTEM)->instituicao();
        return $InstituicaoDAO->buscar($StBusca);
    }

}
