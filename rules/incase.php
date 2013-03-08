<?php

class incase extends AbstractStructure
{
    private $chain = null;
    private $true = null;
    private $false = null;

    public function __construct($args){
        if(!array_key_exists(0, $args)
        || !array_key_exists(1, $args)
        || !array_key_exists(2, $args)
        || !$args[0] INSTANCEOF Validator){
            throw new exception;
        }

        $this->chain = $args[0];
        $this->true = $args[1];
        $this->false = $args[2];
    }

    protected function run($caller){
        if($this->chain->run($this->result)->valid){
            if($this->true === null) return;
            $subResult = $this->true->run($this->result);
        }else{
            if($this->false === null) return;
            $subResult = $this->false->run($this->result);
        }

        $this->valid = $subResult->valid;
        $this->result = $subResult->result;
        $this->stop = $subResult->stop;
    }
}
