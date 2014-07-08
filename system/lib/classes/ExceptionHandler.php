<?php

class ExceptionHandler {

    public function handleException(Exception $e) {
        echo '<pre>';
       // print_r($e);
        Message::geraErro($e->getMessage());
        echo '<script>window.history.back();</script>';
        die();
        $redirect = new Redirector();
        $redirect->goToUrl(URL_AVALIE);
    }

}
