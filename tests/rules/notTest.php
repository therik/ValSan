<?php
use ValidatorInvoker as v;

class notTest extends PHPUnit_Framework_TestCase
{
    public function testNot(){
        $true = v::not(v::valFalse())->valid;
        $this->assertTrue($true);
        $false = v::not(v::valTrue())->valid;
        $this->assertFalse($false);
    }
}
