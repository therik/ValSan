<?php

class Validator
{
    private $chain=array();

    private $rulesSet = array();

    public $valid = true;
    public $result = null;

    protected $stop = false;

    private $defaultValue;

    public function __construct($func, $args){
        call_user_func_array(array($this, $func), $args);
    }

    public function __call($called, $args){
        $this->chain[] = $this->makeRule($called, $args);
        return $this;
    }

    public function pass(){
        return $this;
    }

    public function not($chain){
        $this->chain[] = array('action_not', $chain);
        return $this;
    }

    public function incase(Validator $condition, Validator $true = null, Validator $false = null){
        $this->chain[] = array('action_incase', array($condition, $true, $false));
        return $this;
    }

    public function stop(){
        $this->chain[] = array('action_stop', array());
        return $this;
    }



    public function run($data){
        $this->result = $data;
        foreach($this->chain as $v){
            $method = $v[0];
            $this->$method($v[1]);
            if($this->stop) break;
        }
        return $this;
    }

    private function makeRule($called, $args){
        $func = substr($called, 3);
        $type = substr($called, 0, 3);
        if(!in_array($type, array('val', 'mod'))) throw new BadMethodCallException("Methods of type '$type' do not exist($func)");

        // if(!in_array($called, $this->rulesSet)){
            // throw new BadMethodCallException('Called an non-existing rule');
            // return;
        // }

        return array('action_'.$type, new $func($args));
    }

    private function action_val(Validatable $rule){
            $this->_mergeValid($rule->val($this->result));
    }

    private function action_mod(Modifyable $rule){
        $this->result = $rule->mod($this->result);
    }

    private function action_incase(array $args){
        list($condition, $true, $false) = $args;

        if($this->_subChain($condition)->valid){
            $this->_subChain($true, true, true, true);
        }else{
            $this->_subChain($false, true, true, true);
        }
    }

    private function action_not($chain){
        $this->_mergeValid( ! $this->_subChain($chain, true, true, false)->valid);
    }

    private function action_stop(){
        $this->stop = true;
    }

    private function _mergeValid($valid){
        $this->valid = $this->valid && $valid;
    }

    private function _subChain(Validator $chain, $setStop = false, $setResult = false, $setValid = false){
        $chain->run($this->result);
        if($setResult) $this->result = $chain->result;
        if($setValid) $this->_mergeValid($chain->valid);
        if($setStop) $this->stop = $this->stop || $chain->stop;
        return $chain;
    }

}
