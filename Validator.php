<?php

class Validator
{
    private $chain=array();

    private $rulesSet = array();

    public $valid = true;
    public $result = null;
    public $stop = false;

    private $flags = array();

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
        $preffix = substr($called, 0, 3);
        if(in_array($preffix, array('val', 'mod'),true)){
            $func = substr($called, 3);
            return array("action_$preffix", new $func($args));
        }else{
            return array("action_struct", new $called($args));
        }
    }

    private function action_val(Validatable $rule){
        $this->_mergeValid($rule->val($this->result));
    }

    private function action_mod(Modifyable $rule){
        $this->result = $rule->mod($this->result);
    }

    private function action_struct(Structureable $rule){
        $return = $rule->struct($this, $this->valid, $this->result, $this->stop);
        list($valid, $result, $stop) = $return;
        $this->_mergeValid($valid);
        $this->_overwriteResult($result);
        $this->_setStopFlag($stop);
    }

    private function _mergeValid($valid){
        $this->valid = $this->valid && $valid;
    }

    private function _overwriteResult($result){
        $this->result = $result;
    }

    private function _setStopFlag($stop){
        $this->stop = (bool)$stop;
    }
}
