<?php

abstract class DAOFactory {

    public static function getDAO($StDBName) {
        switch (strtoupper($StDBName)) {
            case 'MYSQL':
                return new DAOFactoryMySql();
            default:
                break;
        }
    }

}
