<?php

class stop extends AbstractStructure
{
    public $flag_pass_stop = true;

    public function init(Array $args){
    }

    protected function run(){
        $this->stop = true;
    }
}
