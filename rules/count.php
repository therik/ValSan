<?php

class count extends AbstractStructure implements Dataswapperable
{
    public function init(array $args){
        if($this->chain->getType('array_content'))
            throw new exception('cannot add count into content chain');

        $this->chain->disablePassValue();
        $this->chain->disableDataSwap();
        $this->chain->disablePassStop();
        $this->chain->disableModifyable();
        $this->chain->addType('array_atribute');
    }

    public function run(){
        $this->value = $this->chain->getAttribute('array_length');
    }
}
