<?php
use ValidatorInvoker as v;

class equalsTest extends PHPUnit_Framework_TestCase
{
    public function testEquals(){
        $this->assertTrue(v::with('data')->equals('data')->valid);
        $this->assertTrue(v::with('')->equals(null)->valid);
        $this->assertTrue(v::with(0)->equals(null)->valid);
        $this->assertTrue(v::with(false)->equals(0)->valid);
        $this->assertTrue(v::with('')->equals(false)->valid);
        $this->assertTrue(v::with('123')->equals(123)->valid);

        $this->assertFalse(v::with('data')->equals('DaTa')->valid);
        $this->assertFalse(v::with('data')->equals(null)->valid);
        $this->assertFalse(v::with('data')->equals('')->valid);
        $this->assertFalse(v::with(123)->equals('')->valid);
        $this->assertFalse(v::with(123)->equals(-123)->valid);
        $this->assertFalse(v::with(123.5)->equals(123.4)->valid);
    }
}
