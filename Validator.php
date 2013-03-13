<?php

class Validator
{
    private $chain;

    private $passed_atributes = array();

    private $initial_valid = true;
    private $initial_value = null;

    private $flag_data_swap = true;
    private $flag_modifyable = true;

    private $flag_ran = false;

    private $types = array();

    public static function getChainObject(Validator $val){
        return $val->chain;
    }

    public function __construct($func, $args){
        $this->chain = new Chain;
        call_user_func_array(array($this, $func), $args);
    }

    public function __call($called, $args){
        $this->chain[] = $this->makeRule($called, $args);
        return $this;
    }

    /**
    * puts new rule into chain
    */
    private function makeRule($called, $args){
        try{
            $obj = new $called($this, $this->chain, $args);
        }
        catch(ChainException $e){
            throw $e;
        }
        return $obj;
    }

    /**
    * starts validation if it wasn't done yet with current data,
    * returns asked value
    */
    public function __get($var){
        if($var === 'valid'
        || $var === 'value'
        || $var === 'stop'){
            if(! $this->flag_ran) $this->run();
            return $this->chain->$var;
        }
        throw new exception('wrong property');
    }

    /**
    * one way to start validation, another is to just get 'valid' or 'value' property
    */
    public function run(){
        $this->chain->value = $this->initial_value;
        $this->chain->valid = $this->initial_valid;
        $this->chain->stop = false;

        $this->chain->evaluateChain();

        $this->flag_ran = true;
        return $this;
    }

    // private function evaluate_rule(InterfaceRule $rule){
//
    // }

    public function with($data = null, $valid = true){
        $this->initial_value = $data;
        $this->initial_valid = $valid;
        $this->flag_ran = false;
        return $this;
    }

    // public function setValid($bool){
    //     $this->initial_valid = $bool;
    //     $this->flag_ran = false;
    //     return $this;
    // }

    /**
    * dummy method, changes nothing
    */
    public function pass(){
        return $this;
    }

    public function chainIsOfType($type){
        return $this->chain->isOfType($type);
    }

}
