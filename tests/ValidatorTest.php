<?php
use ValidatorInvoker as v;

class ValidatorTest extends PHPUnit_Framework_TestCase
{
    public function testValidator(){
        $val = v::valTrue('asd');
        $this->assertTrue($val->pass()->run('asd')->valid);
        $this->assertSame('whatever', $val->pass()->run('whatever')->result);

    }
}

