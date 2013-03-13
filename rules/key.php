<?php

class key extends AbstractStructure
{
    private $subchain;

    public $flag_pass_stop = true;

    protected $required_type = 'array-content';

    public function init(array $args){
        if(array_key_exists(0, $args)
        && $args[0] INSTANCEOF Validator){
            $this->subchain = $this->extractChain($args[0]);
        }
    }

    public function run(){
        $paramGrp = $this->chain->getParameterGroup('arr');

        $this->subchain->value = $paramGrp['key'];

        $this->subchain->evaluateChain();

        if(!$this->subchain->valid) $this->stop = true;
    }
}
