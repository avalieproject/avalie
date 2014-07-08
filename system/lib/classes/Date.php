<?php

class Date {

    public static function dateBD2BR($StDate) {
        if (!$StDate)
            return false;

        $ArDate = explode('-', $StDate);
        return $ArDate[2] . '/' . $ArDate[1] . '/' . $ArDate[0];
    }

    public static function dateBR2BD($StDate) {
        if (!$StDate)
            return false;

        $ArDate = explode('/', $StDate);
        return $ArDate[2] . '-' . $ArDate[1] . '-' . $ArDate[0];
    }

}
