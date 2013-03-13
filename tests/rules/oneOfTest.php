<?php
use ValidatorInvoker as v;

class oneOfTest extends PHPUnit_Framework_TestCase
{
    public function testInSet(){
        $false = v::with('whatever')->oneOf('value1', 'value2', 'value3')->valid;
        $true = v::with('whatever')->oneOf('value1', 'value2', 'whatever', 'value3')->valid;
        $this->assertFalse($false);
        $this->assertTrue($true);
    }
}
