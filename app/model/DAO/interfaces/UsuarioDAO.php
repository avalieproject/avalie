<?php

interface UsuarioDAO {

    public function cadastrar(Usuario $Usuario);

    public function autenticar(Usuario $Usuario);
    
}
