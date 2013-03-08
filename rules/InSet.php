<?php

class InSet implements Validatable
{
    private $set;

    public function __construct(array $args){
        $this->set = $args;
    }

    public function val($value){
        return in_array($value, $this->set);
    }
}
