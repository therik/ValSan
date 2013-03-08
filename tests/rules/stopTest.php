<?php
use ValidatorInvoker as v;

class stopTest extends PHPUnit_Framework_TestCase
{
    public function testStop(){
        $true = v::stop()->valFalse()->run('whatever')->valid;
        $this->assertTrue($true);
        $false = v::valFalse()->stop()->valTrue()->run('whatever')->valid;
        $this->assertFalse($false);

        $data = v::pass()->pass()->stop()->modRewrite('rewriten')->run('data')->result;
        $this->assertSame('data', $data);

    }
}
