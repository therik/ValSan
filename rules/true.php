<?php

class true extends AbstractRule implements InterfaceValidator
{
    public $flag_pass_valid = true;

    protected function init(array $args){}
    protected function run(){
        $this->valid = true;
    }
}
