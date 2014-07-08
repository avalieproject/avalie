<?php

class UsuarioModel {

    public function cadastrar($ArUsuario) {
        $ArUsuario['StSenha'] = md5($ArUsuario['StSenha']);
        $Usuario = new Usuario($ArUsuario);
        $UsuarioDAO = DAOFactory::getDAO(DB_SYSTEM)->usuario();
        return $UsuarioDAO->cadastrar($Usuario);
    }

    public function getByEmail($StEmail) {
        Validar::Email($StEmail, 'Email informado é inválido');
        $UsuarioDAO = DAOFactory::getDAO(DB_SYSTEM)->usuario();
        return $UsuarioDAO->getByEmail($StEmail);
    }

    public function autenticar($ArUsuario) {
        Validar::String($ArUsuario['StEmail'], 'Email informado é inválido.');
        Validar::String($ArUsuario['StSenha'], 'Senha informada é inválida.');
        $ArUsuario['StSenha'] = md5($ArUsuario['StSenha']);

        $Usuario = new Usuario($ArUsuario);
        $UsuarioDAO = DAOFactory::getDAO(DB_SYSTEM)->usuario();
        return $UsuarioDAO->autenticar($Usuario);
    }

    public function criaSessao(Usuario $Usuario) {
        Session::set('Usuario', $Usuario);
    }

    public function editar($ArUsuario) {
        Validar::String($ArUsuario['StEmail'], 'Email informado é inválido.');
        Validar::String($ArUsuario['StNome'], 'Nome informado é inválido.');
        $Usuario = new Usuario($ArUsuario);
        $UsuarioDAO = DAOFactory::getDAO(DB_SYSTEM)->usuario();
        return $UsuarioDAO->editar($Usuario);
    }

}
