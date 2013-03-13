<?php
use ValidatorInvoker as v;

class notTest extends PHPUnit_Framework_TestCase
{
    public function testNot(){
        $true = v::not(v::false())->valid;
        $this->assertTrue($true);
        $false = v::not(v::true())->valid;
        $this->assertFalse($false);
    }

    public function testPassingValues(){
        $this->assertSame('another', v::with('one')->not(v::rewrite('another'))->value);
    }

    public function testStoppingChainValid(){
        $this->assertTrue(v::not(v::false()->stop()->true())->false()->valid);
        $this->assertFalse(v::not(v::stop()->false())->true()->valid);

    }

    public function testStoppingChain(){

        $val = v::with('one')
            ->not(v::stop())
            ->rewrite('another');
        $this->assertEquals('one', $val->value);
        $this->assertFalse($val->valid);

        $val = v::with('one')
            ->not(v::true()->stop())
            ->rewrite('another');
        $this->assertEquals('one', $val->value);
        $this->assertFalse($val->valid);
    }
}

