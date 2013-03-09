<?php

class key extends AbstractStructure implements Dataswapperable
{
    private $chain;

    public function init(array $args){
        $this->chain = $args[0];
        if($this->chain->getType('array_content'))
            throw new exception('cannot add count into content chain');

        // $this->chain->disablePassValue();
        // $this->chain->disablePassStop();
        // $this->chain->disableDataSwap();
        // $this->chain->disableModifyable();
        $this->chain->addType('array_content');
    }

    public function run(){
        $this->value = $this->chain->getAttribute('array_keys');

    }
}
