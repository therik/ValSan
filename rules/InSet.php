<?php

class InSet extends AbstractRule implements Validatable
{
    private $set;

    public function init(array $args){
        $this->set = $args;
    }

    public function val($value){
        return in_array($value, $this->set);
    }
}
