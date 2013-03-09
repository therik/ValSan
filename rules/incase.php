<?php

class incase extends AbstractStructure
{
    private $condition = null;
    private $true = null;
    private $false = null;

    public function init(array $args){
        if(!array_key_exists(0, $args)
        || !array_key_exists(1, $args)
        || !array_key_exists(2, $args)
        || !$args[0] INSTANCEOF Validator){
            throw new exception;
        }

        $this->condition = $args[0];
        $this->true = $args[1];
        $this->false = $args[2];
    }

    protected function run(){
        if($this->condition->with($this->value)->valid){
            if($this->true === null) return;
            $subResult = $this->true->with($this->value);
        }else{
            if($this->false === null) return;
            $subResult = $this->false->with($this->value);
        }

        $this->valid = $subResult->valid;
        $this->value = $subResult->value;
        $this->stop = $subResult->stop;
    }
}
