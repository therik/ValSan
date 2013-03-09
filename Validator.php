<?php

class Validator
{
    private $chain=array(); // holds set of rule classes

    private $passed_atributes = array();

    private $valid = true;
    private $value = null;
    private $stop = false;

    private $flag_pass_valid = true;
    private $flag_pass_value = true;
    private $flag_pass_stop = true;

    private $flag_data_swap = true;

    private $flag_modifyable = true;

    private $flag_ran = false;

    private $types = array();

    public function __construct($func, $args){
        call_user_func_array(array($this, $func), $args);
    }

    public function __call($called, $args){
        $this->chain[] = $this->makeRule($called, $args);
        return $this;
    }

    /**
    * dummy method, changes nothing
    */
    public function pass(){
        return $this;
    }

    /**
    * assigns data to validator
    */
    public function with($data){
        if(!$this->flag_data_swap) throw new Exception('Data cannot be changed in this chain');
        $this->value = $data;
        $this->flag_ran = false;
        return $this;
    }

    /**
    * starts validation if it wasn't done yet with current data,
    * returns asked value
    */
    public function __get($var){
        if($var === 'valid'
        || $var === 'value'){
            if(! $this->flag_ran) $this->run();
            return $this->$var;
        }
    }

    /**
    * one way to start validation, another is to just get 'valid' or 'value' property
    */
    public function run(){
        foreach($this->chain as $v){
            $method = $v[0];

            // sometimes, modifications aren't possible
            if($method == 'action_mod'
            && ! $this->flag_modifyable) throw new exception('attempted to modify unmodifyable value');

            $this->$method($v[1]);
            if($this->stop) break;
        }
        $this->flag_ran = true;
        return $this;
    }

    /**
    * puts new rule into chain
    */
    private function makeRule($called, $args){
        $preffix = substr($called, 0, 3);
        if(in_array($preffix, array('val', 'mod'),true)){
            $func = substr($called, 3);

            $obj = new $func($this, $args);
            if($obj INSTANCEOF Modifyable && ! $this->flag_modifyable)
                throw new exception('this chain is not modifyable');

            return array("action_$preffix", $obj);
        }else{

            $obj = new $called($this, $args);
            if($obj == 'Dataswapperable' && ! $this->flag_data_swap)
                throw new exception('dataswapper cannot be in this chain;
                                     there is probably one already');

            return array("action_struct", $obj);
        }
    }

    /**
    * validation
    */
    private function action_val(Validatable $rule){
        $this->_mergeValid($rule->val($this->value));
    }

    /**
    * modification
    */
    private function action_mod(Modifyable $rule){
        $this->value = $rule->mod($this->value);
    }

    /**
    * controll structures
    */
    private function action_struct(Structureable $rule){
        $return = $rule->struct($this->valid, $this->value, $this->stop);
        list($valid, $value, $stop) = $return;
        $this->_mergeValid($valid);
        $this->_overwriteValue($value);
        $this->_setStopFlag($stop);
    }

    private function _mergeValid($valid){
        $this->valid = $this->valid && $valid;
    }

    private function _overwriteValue($value){
        $this->value = $value;
    }

    private function _setStopFlag($stop){
        $this->stop = (bool)$stop;
    }

    public function getType($name){
        return array_key_exists($name, $this->types);
    }

    public function addType($type){
        $this->types[$type] = true;
    }

    public function passAttributes($attributes){
        $this->attributes = $attributes;
        return $this;
    }

    public function getAttribute($key){
        if(array_key_exists($key, $this->attributes)) return $this->attributes[$key];
        else throw new exception('asked for non-existing atribute, probably wrong chain structure');
        return $this;
    }

    public function preSetState($valid, $stop){
        $this->valid = $valid;
        $this->stop = $stop;
        return $this;
    }

    public function getState(){
        $state = array();
        if($this->flag_pass_valid) $state['valid'] = $this->valid;
        if($this->flag_pass_value) $state['value'] = $this->value;
        if($this->flag_pass_stop) $state['stop'] = $this->stop;
        return $state;
    }

    public function disablePassValue(){
        $this->flag_pass_value = false;
    }
    public function disablePassValid(){
        $this->flag_pass_valid = false;
    }
    public function disablePassStop(){
        $this->flag_pass_stop = false;
    }
    public function disableDataSwap(){
        $this->flag_data_swap = false;
    }
    public function disableModifyable(){
        $this->flag_modifyable = false;
    }
}
