<?php
abstract class AbstractStructure extends AbstractRule implements Structureable
{
    protected $valid;
    protected $value;
    protected $stop;

    abstract protected function run();

    public final function struct($valid, $value, $stop){
        $this->valid = $valid;
        $this->value = $value;
        $this->stop = $stop;

        $this->run();
        return array($this->valid, $this->value, $this->stop);
    }

    protected function commitState(array $state){
        if(array_key_exists('valid', $state)) $this->valid = $state['valid'];
        if(array_key_exists('value', $state)) $this->value = $state['value'];
        if(array_key_exists('stop', $state)) $this->stop = $state['stop'];
    }
}
