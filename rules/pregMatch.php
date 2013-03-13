<?php

class pregMatch extends AbstractRule implements InterfaceValidator
{
    private $regex = '';
    private $replace = '';

    public $flag_pass_valid = true;

    protected $numRequiredArgs = 1;

    public function init(array $args){
        $this->regex = $args[0];
    }

    public function run(){
        $valid = preg_match($this->regex, $this->value);
        if($valid === false) throw new InvalidArgumentException;
        else $this->valid = (bool)$valid;
    }
}
