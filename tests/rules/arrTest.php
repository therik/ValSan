<?php
use ValidatorInvoker as v;

class arrTest extends PHPUnit_Framework_TestCase
{
    public function testOnlyArrayValid(){
        // $this->markTestIncomplete();
        $this->assertTrue(v::with(array())->arr()->valid);
        $this->assertFalse(v::with(null)->arr()->valid);
        $this->assertFalse(v::with(true)->arr()->valid);
        $this->assertFalse(v::with(false)->arr()->valid);
        $this->assertFalse(v::with('string')->arr()->valid);
        $this->assertFalse(v::with(new stdClass)->arr()->valid);
        $this->assertFalse(v::with(2.25)->arr()->valid);
        $this->assertFalse(v::with(15)->arr()->valid);
        $this->assertFalse(v::with(NAN)->arr()->valid);
    }

    public function testPassEmptyArray(){
        // $this->markTestIncomplete();
        $this->assertSame(array(), v::with(array())->arr()->value);
    }

    public function testNotPassNonEmptyArray(){
        // $this->markTestIncomplete();

        $val = v::with(array('not empty'))->arr();

        $this->assertFalse($val->valid);
        $this->assertSame(array('not empty'), $val->value);
    }


}
