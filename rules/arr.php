<?php

class arr extends AbstractStructure
{
    // private $subchains = array();
    private $attribute_chains = array();
    private $content_chains = array();


    public function init(array $args){
        foreach($args as $v){
            if(! $v INSTANCEOF Validator){
                throw new exception('all arr() parametters must be validators');
            }

            if($v->getType('array_atribute')){
                $this->attribute_chains[] = $v;
            }elseif($v->getType('array_content')){
                $this->content_chains[] = $v;
            }else{
                throw new exception('wrong chain in arr structure');
            }
        }


        // $this->subchains = $args;
    }

    public function run(){
        if(!is_array($this->value)){
            $this->valid = false;
            $this->stop = true;
            $this->value = null;
        }

        $attributes = array('array_length' => count($this->value));

        foreach($this->attribute_chains as $v){
            $chain = $v->passAttributes($attributes)->run();
            $this->commitState($chain->getState());
        }
    }
}
