<?php

abstract class AbstractRule implements InterfaceRule
{
    protected $chain;
    protected $validator;
    protected $numRequiredArgs = 0;

    protected $valid;
    protected $value;
    protected $stop;

    public $flag_pass_valid = false;
    public $flag_pass_value = false;
    public $flag_pass_stop = false;

    protected $required_type = '';

    abstract protected function init(array $args);
    abstract protected function run();

    public function __construct(Validator $validator, Chain $chain, array $args){
        $this->validator = $validator;
        $this->chain = $chain;

        $type_match = $this->chain->tryType($this->required_type);
        if(!$type_match) throw new ChainException("Incompatible chain types!
            Attempted to match chain type to ($this->required_type),
            but it already is of type (".$this->chain->getType().')');


        if(count($args) < $this->numRequiredArgs)
            throw new ChainException('Missing argument in '.__CLASS__);
        $this->init($args);
    }

    public function evaluate($valid, $value, $stop){
        $this->valid = $valid;
        $this->value = $value;
        $this->stop = $stop;

        $this->run();

        return array($this->valid, $this->value, $this->stop);
    }

}
