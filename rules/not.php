<?php

class not extends AbstractStructure
{
    private $subchain;

    public function init(array $args){
        if(array_key_exists(0, $args)) $this->subchain = $args[0];
    }

    protected function run(){
        $this->subchain->run($this->value);

        $this->valid = !$this->subchain->valid;
        $this->value = $this->subchain->value;
        $this->stop = $this->subchain->stop;
    }

    protected function runSubChain($chain){
        $chain->passState($this->valid, $this->value, $this->stop);
    }
}
