<?php

abstract class AbstractRule implements Ruleable
{
    protected $chain;

    abstract protected function init(array $args);

    public function __construct(Validator $chain, array $args){
        $this->chain = $chain;
        $this->init($args);
    }

}
