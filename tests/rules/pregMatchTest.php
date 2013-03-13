<?php
use ValidatorInvoker as v;

class pregMatchTest extends PHPUnit_Framework_TestCase
{
    public function testPregMatch(){
        $true = v::with('numbers: 225652')->pregMatch('/^numbers: \d+$/')->valid;
        $false = v::with('numbers: 16.52')->pregMatch('/^numbers: \d+$/')->valid;

        $this->assertTrue($true);
        $this->assertFalse($false);
    }
}
