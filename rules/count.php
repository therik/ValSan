<?php

class count extends AbstractStructure implements InterfaceDataProvider
{
    public $flag_pass_value = true;
    protected $required_type = 'array';

    public function init(array $args){
    }

    public function run(){
        $paramGrp = $this->chain->getParameterGroup('arr');
        $this->value = $paramGrp['count'];
    }
}
