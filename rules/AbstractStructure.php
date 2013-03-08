<?php
abstract class AbstractStructure implements Structureable
{
    protected $valid;
    protected $result;
    protected $stop;

    abstract protected function run($args);

    public final function struct(Validator $args, $valid, $result, $stop){
        $this->valid = $valid;
        $this->result = $result;
        $this->stop = $stop;

        $this->run($args);
        return array($this->valid, $this->result, $this->stop);
    }
}
