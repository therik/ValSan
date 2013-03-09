<?php
use ValidatorInvoker as v;

class arrTest extends PHPUnit_Framework_TestCase
{
    public function testCount(){
        // $this->markTestSkipped();
        $true = v::with(array(1, 2))
            ->arr(
                v::count()->valEquals(2)
            )
            ->valid;

        $false = v::with(array(1, 2, 3))
        ->arr(
            v::count()->valEquals(2)
        )
        ->valid;

        $this->assertTrue($true);
        $this->assertFalse($false);
    }

    public function testKey(){
        $this->markTestSkipped();
        $true = v::with(array('validKey' => 'whatever'))
            ->arr(
                v::key()->valEquals('validKey')
            )
            ->valid;

        $false = v::with(array('invalid' => 'whatever'))
            ->arr(
                v::key()->valEquals('validKey')
            )
            ->valid;

        $this->assertTrue($true);
        $this->assertFalse($false);
    }
}
