<?php

class UnidadeDAOMySQL implements UnidadeDAO {

    private $db;

    public function __construct() {
        $this->db = Registry::getInstance()->get('DATABASE');
    }

    public function getByID($IDUnidade) {
        
    }

    public function listByInstituicao($IDInstituicao) {
        $StSQL = "SELECT
                    *
                  FROM 
                    Unidade u
                  WHERE 
                    u.IDInstituicao = " . $IDInstituicao;
        $this->db->query($StSQL);
        $ArUnidades = $this->db->getResult();
        $ArUnidadesObj = array();
        foreach ($ArUnidades as $ArUnidade) {
            $ArUnidadesObj[] = new Unidade($ArUnidade);
        }
        return $ArUnidadesObj;
    }

}
