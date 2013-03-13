<?php

class arr extends AbstractStructure
{
  // private $subchains = array();
  private $subchains = array();

  protected $numRequiredArgs = 0;

  public $flag_pass_valid = true;
  public $flag_pass_value = true;
  public $flag_pass_stop = false;

  private $count = 0;

  private $unsetAll;

  public function init(array $args){
    foreach($args as $v){
      if(! $v INSTANCEOF Validator){
        throw new exception('all arr() parameters must be validators');
      }

      if(! $v->chainIsOfType('array')) throw new ChainException('arr only accepts array-type-validator subchains');

      $this->subchains[] = $this->extractChain($v);
    }
  }

  public function run(){
    if(!is_array($this->value)){
      $this->valid = false;
      return;
    }

    $this->count = count($this->value);

    foreach($this->value as $key => $value){
      foreach($this->subchains as $sch){
        $sch->value = $value;
        $sch->evaluateChain('arr', array('obj' => $this, 'key' => $key, 'count' => $this->count));

        if($sch->isOfType('array-content')){
          if($sch->stop === true) continue;
          else{

            $paramGrp = $sch->getParameterGroup('arr');

            if(array_key_exists('unset', $paramGrp) && $paramGrp['unset'] === true) {
              unset($this->value[$key]);
            }else{
              $this->valid = ($this->valid && $sch->valid);
            }

            break 2;
          }

        }elseif($sch->isOfType('array-atribute')){
          //+++++++++++++
          // to do...
        }else{
          $this->valid = ($this->valid && $sch->valid);
        }
      }

      // if we passed through all rules
      // and didn't find array-content rule that matched (didn't stop),
      // delete entry from array

      $this->valid = false;
      if($this->unsetAll){
        // unset($this->value[$key]);
      }
    }
  }
}
