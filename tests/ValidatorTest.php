<?php
use ValidatorInvoker as v;

class ValidatorTest extends PHPUnit_Framework_TestCase
{
    public function testValidator(){
        $val = v::valTrue('asd');
        $this->assertTrue($val->pass()->valid);
        $this->assertSame('whatever', $val->with('whatever')->pass()->value);

    }
}

