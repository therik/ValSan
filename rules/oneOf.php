<?php

class oneOf extends AbstractRule implements InterfaceValidator
{
    private $set;

    public $flag_pass_valid = true;

    public function init(array $args){
        $this->set = $args;
    }

    protected function run(){
        $this->valid = in_array($this->value, $this->set);
    }
}
