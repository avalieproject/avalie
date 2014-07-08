<?php

abstract class Session {

    public static function init() {
        session_start();
       // $_SESSION['AVALIE'] = array();
    }

    public static function set($StName, $MxValue) {
        $_SESSION['AVALIE'][$StName] = $MxValue;
    }

    public static function get($StName, $StInd = null) {
        if ($StInd == null)
            return $_SESSION['AVALIE'][$StName];
        else
            return $_SESSION['AVALIE'][$StName][$StInd];
    }

    public static function delete($StName, $StInd = null) {
        if($StInd == null)
            unset($_SESSION['AVALIE'][$StName]);
        else
            unset($_SESSION['AVALIE'][$StName][$StInd]);
    }

    public static function check($StName) {
        return isset($_SESSION['AVALIE'][$StName]);
    }

    public static function destroy() {
        session_destroy();
        $_SESSION['AVALIE'] = array();
    }

}

?>
