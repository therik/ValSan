<?php

class arr extends AbstractStructure
{
  // private $subchains = array();
  private $subchains = array();

  private $contentSubchains = array();
  private $atributeSubchains = array();

  protected $numRequiredArgs = 0;

  public $flag_pass_valid = true;
  public $flag_pass_value = true;
  public $flag_pass_stop = false;

  private $count = 0;

  private $unsetInvalid = false;

  public function init(array $args){
    foreach($args as $v){
      if(! $v INSTANCEOF Validator){
        throw new exception('all arr() parameters must be validators');
      }

      if(! $v->chainIsOfType('array')) throw new ChainException('arr only accepts array-type-validator subchains');

      if($v->chainIsOfType('array-content')){
        $this->contentSubchains[] = $this->extractChain($v);
      }elseif($v->chainIsOfType('array-atribute')){
        $this->atributeSubchains[] = $this->extractChain($v);
      }else{
        $this->subchains[] = $this->extractChain($v);
      }

    }
  }

  public function run(){
    if(!is_array($this->value)){
      $this->valid = false;
      return;
    }

    $this->count = count($this->value);

    foreach($this->atributeSubchains as $v){
      // var_dump($v->evaluateChain('arr', array('obj' => $this, 'count' => $this->count))->valid);
      $this->valid = $this->valid && $v->evaluateChain('arr', array('obj' => $this, 'count' => $this->count))->valid;
    }

    foreach($this->value as $key => $value){
      $matched = $this->matchItem($key, $value);
    }


  }

  private function matchItem($key, $value){
    foreach($this->contentSubchains as $sch){
      $sch->value = $value;
      $sch->evaluateChain('arr', array('obj' => $this, 'key' => $key, 'count' => $this->count));
      if($sch->stop === true) continue;

      $paramGrp = $sch->getParameterGroup('arr');

      if(array_key_exists('unset', $paramGrp) && $paramGrp['unset'] === true) {
        unset($this->value[$key]);
      }else{
        $this->valid = ($this->valid && $sch->valid);
      }

      return;
    }

    // if we passed through all rules
    // and didn't find array-content rule that matched (didn't stop),
    // delete entry from array

    // $this->valid = false;
    if($this->unsetInvalid){
      unset($this->value[$key]);
    }

  }
}
