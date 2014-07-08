<?php

class UsuarioDAOMySQL implements UsuarioDAO {

    private $db;

    public function __construct() {
        $this->db = Registry::getInstance()->get('DATABASE');
    }

    public function autenticar(Usuario $Usuario) {
        try {
            $StSQL = "SELECT 
                        u.*
                      FROM
                        Usuario u
                      WHERE
                        u.StEmail = '{$Usuario->getStEmail()}' AND u.StSenha = '{$Usuario->getStSenha()}'";

            $this->db->query($StSQL);
            $ArUsuario = $this->db->getResult('row');
            if ($ArUsuario) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception('Erro ao autenticar usuário.');
        }
    }

    public function cadastrar(Usuario $Usuario) {
        try {
            $StSQL = "INSERT INTO
                    Usuario (IDUsuario, StEmail, StSenha, StNome)
                  VALUES
                    (NULL, '{$Usuario->getStEmail()}', '{$Usuario->getStSenha()}', '{$Usuario->getStNome()}')";
            $this->db->exec($StSQL);
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            throw new Exception('Erro ao cadastrar usuário.');
        }
    }

    public function getByEmail($StEmail) {
        try {
            $StSQL = "SELECT 
                        u.*
                      FROM
                        Usuario u
                      WHERE
                        u.StEmail = '{$StEmail}'";
            $this->db->query($StSQL);
            $ArUsuario = $this->db->getResult('row');
            if ($ArUsuario) {
                return new Usuario($ArUsuario);
            }
            return false;
        } catch (Exception $e) {
            throw new Exception('Erro ao obter usuário por email.');
        }
    }

    public function editar(Usuario $Usuario) {
        try {
            $StSQL = "UPDATE
                        Usuario 
                      SET
                        StEmail = '{$Usuario->getStEmail()}',
                        StNome = '{$Usuario->getStNome()}'   
                      WHERE
                        IDUsuario = {$Usuario->getIDUsuario()}";
            return $this->db->exec($StSQL);
        } catch (Exception $e) {
            throw new Exception('Erro ao atualizar usuário.');
        }
    }

}
