<?php

class not extends AbstractStructure
{
    private $subValidator;

    protected $numRequiredArgs = 1;

    public $flag_pass_valid = true;
    public $flag_pass_value = true;
    public $flag_pass_stop = true;

    public function init(array $args){
        $this->subValidator = $args[0];
    }

    protected function run(){
        $subChain = $this->prepareSubChain($this->extractChain($this->subValidator))->evaluateChain();

        $this->valid = !$subChain->valid;
        $this->value = $subChain->value;
        $this->stop = $subChain->stop;
    }
}

