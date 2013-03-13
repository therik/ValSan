<?php

class key extends AbstractStructure
{
    private $subchain;

    public $flag_pass_stop = true;

    protected $required_type = 'array-content';

    public function init(array $args){
        if(array_key_exists(0, $args)){
            if($args[0] INSTANCEOF Validator){
                $this->subchain = $this->extractChain($args[0]);
            }elseif($args[0] === null){
                $this->subchain = new Chain;
            }
        }else{
            $this->subchain = new Chain;
        }


    }

    public function run(){
        $paramGrp = $this->chain->getParameterGroup('arr');

        $sc = $this->subchain;

        $sc->value = $paramGrp['key'];

        $this->subchain->evaluateChain();

        if(!$this->subchain->valid) $this->stop = true;
    }
}
