<?php
use ValidatorInvoker as v;

class notTest extends PHPUnit_Framework_TestCase
{
    public function testNot(){
        $true = v::not(v::valFalse())->run('whatever')->valid;
        $this->assertTrue($true);
        $false = v::not(v::valTrue())->run('whatever')->valid;
        $this->assertFalse($false);
    }
}
