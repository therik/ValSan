<?php
use ValidatorInvoker as v;

class stopTest extends PHPUnit_Framework_TestCase
{

    public function testStop(){
        $true = v::stop()->false()->valid;
        $this->assertTrue($true);
        $false = v::false()->stop()->true()->valid;
        $this->assertFalse($false);

        $data = v::with('data')->pass()->pass()->stop()->rewrite('rewriten')->value;
        $this->assertSame('data', $data);

    }
}
