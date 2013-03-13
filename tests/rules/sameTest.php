<?php
use ValidatorInvoker as v;

class sameTest extends PHPUnit_Framework_TestCase
{
    public function testSame(){
        $this->assertTrue(v::with('data')->same('data')->valid);
        $this->assertFalse(v::with('')->same(null)->valid);
        $this->assertFalse(v::with(0)->same(null)->valid);
        $this->assertFalse(v::with(false)->same(0)->valid);
        $this->assertFalse(v::with('')->same(false)->valid);
        $this->assertFalse(v::with('123')->same(123)->valid);

        $this->assertFalse(v::with('data')->same('DaTa')->valid);
        $this->assertFalse(v::with('data')->same(null)->valid);
        $this->assertFalse(v::with('data')->same('')->valid);
        $this->assertFalse(v::with(123)->same('')->valid);
        $this->assertFalse(v::with(123)->same(-123)->valid);
        $this->assertFalse(v::with(123.5)->same(123.4)->valid);
    }
}
