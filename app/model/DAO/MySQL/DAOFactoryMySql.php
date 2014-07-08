<?php

class DAOFactoryMySql {

    public function instituicao() {
        return new InstituicaoDAOMySQL();
    }

    public function unidade() {
        return new UnidadeDAOMySQL();
    }

    public function avaliacao() {
        return new AvaliacaoDAOMySQL();
    }

    public function questao() {
        return new QuestaoDAOMySQL();
    }

    public function usuario() {
        return new UsuarioDAOMySQL();
    }

}
