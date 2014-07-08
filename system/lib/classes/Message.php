<?php

class Message {

    public static function geraSucesso($StMessage) {
        self::setMessage($StMessage, true);
    }

    public static function geraErro($StMessage) {
        self::setMessage($StMessage, false);
    }

    public function geraAviso($StMessage) {
        self::setMessage($StMessage, 'aviso');
    }

    public static function setMessage($StMessage, $StType) {
        $ArReturnMessage = array('StMessage' => $StMessage, 'StType' => $StType);
        Session::set('ArReturnMessage', $ArReturnMessage);
    }

    public static function getMessage() {
        if (Session::check('ArReturnMessage')) {
            $ArReturnMessage = Session::get('ArReturnMessage');
            Session::delete('ArReturnMessage');
            return $ArReturnMessage;
        } else
            return array();
    }

}

?>
