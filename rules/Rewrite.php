<?php

class Rewrite implements Modifyable
{
    private $value;

    public function __construct(array $args){
        $this->value = $args[0];
    }

    public function mod($value){
        return $this->value;
    }
}