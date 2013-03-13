<?php

class Chain extends ArrayObject
{
    public $valid = true;
    public $value = null;
    public $stop = false;

    public $flag_parent_pass_valid = true;
    public $flag_parent_pass_value = true;
    public $flag_parent_pass_stop = true;

    private $chainParameters = array();

    private $chainType = array();

    public function makeSubChain(Chain $subChain){
        $clone = clone $this;
        $clone->exchangeArray($subChain->getArrayCopy());
        return $clone;
    }

    public function containsRule($name){
        if(!is_string($name) && !is_object($name)) return false;
        foreach($this as $v){
            if($v INSTANCEOF $name) return true;
        }
        return false;
    }

    public function evaluateChain($paramGroup = null, array $passedParameters = array()){
        if(is_string($paramGroup)) $this->setParameterGroup($paramGroup, $passedParameters);

        foreach($this as $v){
            list($this->valid, $this->value, $this->stop) = $v->evaluate($this->valid, $this->value, $this->stop);

            if($this->stop) break;
        }
        return $this;
    }

    private function setParameterGroup($group, array $params){
        $this->chainParameters[$group] = $params;
    }

    public function getParameterGroup($group){
        if(array_key_exists($group, $this->chainParameters)) return $this->chainParameters[$group];
        return null;
    }

    public function isOfType($type){
        $typeArray = ($type !== '') ? explode('-', $type) : array() ;

        $match = $this->compareType($typeArray);

        return ($match === 'match' || $match === 'super_type');
    }

    public function getType(){
        return implode('-', $this->chainType);
    }

    public function tryType($type){
        $typeArray = ($type !== '') ? explode('-', $type) : array() ;

        $relationship = $this->compareType($typeArray);

        switch($relationship){
            case 'match':
                return true;
            break;
            case 'super_type':
                return true;
            break;
            case 'sub_type':
                $this->chainType = $typeArray;
                return true;
            break;
            case 'different':
                return false;
            break;
        }
    }

    private function compareType($typeArray){
        $paralelLength = min(count($typeArray), count($this->chainType));

        for($i = 0; $i<$paralelLength; $i++){
            if($typeArray[$i] !== $this->chainType[$i]) return 'different';
        }


        if(count($typeArray) < count($this->chainType)) return 'super_type';
        elseif(count($typeArray) == count($this->chainType)) return 'match';
        else return 'sub_type';
    }

    public function forceType($type){
        $this->chainType = explode('-', $type);;
        return $this;
    }
}
