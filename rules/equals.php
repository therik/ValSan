<?php

class equals extends AbstractRule implements InterfaceValidator
{
    private $equals;

    protected $numRequiredArgs = 1;

    public $flag_pass_valid = true;

    public function init(array $args){
        $this->equals = $args[0];
    }

    public function run(){
        $this->valid = ($this->value == $this->equals);
    }
}
