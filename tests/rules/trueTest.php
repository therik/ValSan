<?php
use ValidatorInvoker as v;

class trueTest extends PHPUnit_Framework_TestCase
{
    public function testTrue(){
        $this->assertTrue(v::true()->valid);
    }

}
