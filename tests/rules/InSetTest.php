<?php
use ValidatorInvoker as v;

class InSetTest extends PHPUnit_Framework_TestCase
{
    public function testInSet(){
        $false = v::with('whatever')->valInSet('value1', 'value2', 'value3')->valid;
        $true = v::with('whatever')->valInSet('value1', 'value2', 'whatever', 'value3')->valid;
        $this->assertFalse($false);
        $this->assertTrue($true);
    }
}
