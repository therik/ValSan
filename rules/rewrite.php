<?php

class rewrite extends AbstractRule implements InterfaceModifier
{
    private $rewriteValue;
    public $flag_pass_value = true;

    public function init(array $args){
        $this->rewriteValue = $args[0];
    }

    public function run(){
        $this->value = $this->rewriteValue;
    }
}
