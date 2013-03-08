<?php

class Equals implements Validatable
{
    private $equals;
    private $strict = false;

    public function __construct($args){
        if(count($args) <1 ) throw new BadMethodCallException('Missing parametter for Equals');
        $this->equals = $args[0];
        if(array_key_exists(1, $args)) $this->strict = $args[1];
    }

    public function val($value){
        if($this->strict) return ($value === $this->equals);
        else return ($value == $this->equals);
    }
}
