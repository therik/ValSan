<?php

class not extends AbstractStructure
{
    private $subchain;

    public function __construct(array $args){
        if(array_key_exists(0, $args)) $this->subchain = $args[0];
    }

    protected function run($caller){
        $this->subchain->run($this->result);

        $this->valid = !$this->subchain->valid;
        $this->result = $this->subchain->result;
        $this->stop = $this->subchain->stop;
    }
}
