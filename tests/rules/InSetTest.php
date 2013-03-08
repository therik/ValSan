<?php
use ValidatorInvoker as v;

class InSetTest extends PHPUnit_Framework_TestCase
{
    public function testInSet(){
        $false = v::valInSet('value1', 'value2', 'value3')->run('whatever')->valid;
        $true = v::valInSet('value1', 'value2', 'whatever', 'value3')->run('whatever')->valid;
        $this->assertFalse($false);
        $this->assertTrue($true);
    }
}
