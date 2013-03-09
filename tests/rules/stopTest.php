<?php
use ValidatorInvoker as v;

class stopTest extends PHPUnit_Framework_TestCase
{

    public function testStop(){
        $true = v::stop()->valFalse()->valid;
        $this->assertTrue($true);
        $false = v::valFalse()->stop()->valTrue()->valid;
        $this->assertFalse($false);

        $data = v::with('data')->pass()->pass()->stop()->modRewrite('rewriten')->value;
        $this->assertSame('data', $data);

    }
}
