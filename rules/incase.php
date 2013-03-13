<?php

class incase extends AbstractStructure
{
    private $condition = null;
    private $true = null;
    private $false = null;

    public $flag_pass_valid = true;
    public $flag_pass_value = true;
    public $flag_pass_stop = true;

    protected $numRequiredArgs = 2;

    public function init(array $args){
        if(!$args[0] INSTANCEOF Validator
        || (!$args[1] INSTANCEOF Validator && $args[1] !== null)
        || (!$args[2] INSTANCEOF Validator && $args[2] !== null)
        ){
            throw new exception;
        }

        $this->condition = $args[0];
        $this->true = $args[1];
        $this->false = $args[2];
    }

    protected function run(){
        if($this->prepareSubChain($this->extractChain($this->condition))->evaluateChain()->valid){
            if($this->true === null) return;
            $subResult = $this->prepareSubChain($this->extractChain($this->true))->evaluateChain();
        }else{
            if($this->false === null) return;
            $subResult = $this->prepareSubChain($this->extractChain($this->false))->evaluateChain();
        }
        $this->valid = $subResult->valid;
        $this->value = $subResult->value;
        $this->stop = $subResult->stop;
    }
}
