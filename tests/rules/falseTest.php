<?php
use ValidatorInvoker as v;

class falseTest extends PHPUnit_Framework_TestCase
{
    public function testFalse(){
        $this->assertFalse(v::false()->valid);
    }

}
