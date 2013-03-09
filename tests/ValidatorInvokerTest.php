<?php
use ValidatorInvoker as v;

class ValidatorInvokerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // your code here
    }

    public function tearDown()
    {
        // your code here
    }

    public function testValidatInvoker(){
        $val = v::pass();
        $this->assertInstanceOf('Validator', $val);
    }
}

