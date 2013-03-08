<?php
use ValidatorInvoker as v;

class RewriteTest extends PHPUnit_Framework_TestCase
{
    public function testRewrite(){
        $rewriten = v::modRewrite('rewriten')->run('whatever')->result;
        $this->assertSame('rewriten', $rewriten);
    }
}