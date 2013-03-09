<?php
use ValidatorInvoker as v;

class countTest extends PHPUnit_Framework_TestCase
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

    public function testCountShouldNotPassValue(){
        $value = v::with(array(1, 2))
            ->arr(
                  v::count()->valEquals(2)
            )
            ->value;

        $this->assertSame(array(1, 2), $value);
    }

    public function testCountMakesChainUnmodifyable(){
        $this->setExpectedException('Exception');
        $value = v::with(array('something'))
            ->arr(
                  v::count()->modRewrite('3')
            )
            ->run();
    }
}
