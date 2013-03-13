<?php
use ValidatorInvoker as v;

class countTest extends PHPUnit_Framework_TestCase
{

    public function testCount(){
        // $this->markTestIncomplete();
        // $this->markTestSkipped();
        $true = v::with(array(1, 2))
            ->arr(v::count()->equals(2)
            )
            ->valid;

        $this->assertTrue($true);

        $false = v::with(array(1, 2, 3))
        ->arr(v::count()->equals(2)
        )
        ->valid;

        $this->assertFalse($false);
    }

    public function testCountShouldNotPassValue(){
        // $this->markTestIncomplete();
        // $this->markTestSkipped();
        $value = v::with(array(1, 2))
            ->arr(
                  v::count()->equals(2)
            )
            ->value;

        $this->assertSame(array(1, 2), $value);
    }
}
