<?php
use ValidatorInvoker as v;

class RewriteTest extends PHPUnit_Framework_TestCase
{
    public function testRewrite(){
        $rewriten = v::with('whatever')->modRewrite('rewriten')->value;
        $this->assertSame('rewriten', $rewriten);
    }
}
