<?php

require_once('system/config.php');
require_once('app/view/locale/pt_BR/language.php');
require_once('system/bootstrap.php');
require_once('system/controller.php');

function __autoload($file) {
    $ArDiretorios = array(CONTROLLERS, MODELS, MODELS_SERVICES, DAO_MYSQL, APP_ENTITY, DAO_INTERFACES, LIB_CLASS);
    foreach ($ArDiretorios as $StDir) {
        if (file_exists($StDir . $file . '.php')) {
            require_once ($StDir . $file . '.php');
        }
    }
}

set_exception_handler(array("ExceptionHandler", "handleException"));
Session::init();

$db = new DataBase(DB_HOST, DB_NAME, DB_USER, DB_PASS);
Registry::getInstance()->set('DATABASE', $db);

$Bootstrap = new Bootstrap();
$Bootstrap->run();
?>
