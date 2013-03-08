<?php

class stop extends AbstractStructure
{
    protected function run($caller){
        $this->stop = true;
    }
}
