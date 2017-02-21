<?php

namespace Synch\Image\Replace;

class Logs {

    public static function get() {
        if(isset($_SESSION[__CLASS__])) {
            $data = $_SESSION[__CLASS__];
            unset($_SESSION[__CLASS__]);
            return $data;
        } else {
            return array();
        }
    }

    public static function add($message) {
        if(empty($_SESSION[__CLASS__])) {
            $_SESSION[__CLASS__] = array();
        }
        $_SESSION[__CLASS__][] = $message;
    }

}
