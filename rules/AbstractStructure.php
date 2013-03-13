<?php
// use Validator;
abstract class AbstractStructure extends AbstractRule implements InterfaceStructure
{
    protected function extractChain(Validator $val){
        return Validator::getChainObject($val);
    }

    public function prepareSubChain(Chain $subChain){
        return $this->chain->makeSubChain($subChain);
    }




}
