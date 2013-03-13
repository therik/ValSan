<?php
use ValidatorInvoker as v;

class ValidatorTest extends PHPUnit_Framework_TestCase
{
    public function testValidator(){
        $val = v::pass();
        $this->assertTrue($val->pass()->valid);
        $this->assertInstanceOf('validator', $val);
    }

    public function testWith(){
        $this->assertSame('whatever', v::with('whatever')->value);

        $val = v::with('first');
        $this->assertSame('first', $val->value);
        $val->with('second');
        $this->assertSame('second', $val->value);
        $this->assertSame('third', $val->with('third')->value);


        $this->assertSame('fourth', v::with('first')->with('second')->with('third')->with('fourth')->value);
    }

    public function testValid(){
        $this->assertTrue(v::with(null, true)->valid);
        $this->assertFalse(v::with(null, false)->valid);

        $val = v::with(null, false);
        $this->assertFalse($val->valid);
        $val->with(null, true);
        $this->assertTrue($val->valid);

        $this->assertFalse(v::with(null, false)->with(null, true)->with(null, false)->valid);

    }

    public function testStop(){
        $this->assertFalse(v::pass()->stop);
        $val = v::stop();
        $this->assertTrue($val->stop);
        $this->assertTrue(v::stop()->stop);

    }

    public function testNonPropertyException(){
        $this->setExpectedException('exception');
        v::pass()->non_existing_property;
    }

}





