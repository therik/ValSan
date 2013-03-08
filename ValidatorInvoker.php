<?php

class ValidatorInvoker
{

    private $data;

    public static function __callStatic($func, $args){
        return new Validator($func, $args);
    }
}