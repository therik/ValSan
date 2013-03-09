<?php

class Rewrite extends AbstractRule implements Modifyable
{
    private $value;

    public function init(array $args){
        $this->value = $args[0];
    }

    public function mod($value){
        return $this->value;
    }
}
