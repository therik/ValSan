<?php

class Preg implements Validatable, Modifyable
{
    private $regex = '';
    private $replace = '';

    public function __construct($args){
        $this->regex = $args[0];
        if(count($args) > 1) $this->replace = $args[1];
    }

    public function val($value){
        return preg_match($this->regex, $value);
    }

    public function mod($value){
        return preg_replace($this->regex, $this->replace, $value);
    }
}



