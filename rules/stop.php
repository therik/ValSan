<?php

class stop extends AbstractStructure
{
    public function init(Array $args){

    }

    protected function run(){
        $this->stop = true;
    }
}
