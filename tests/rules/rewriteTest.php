<?php
use ValidatorInvoker as v;

class rewriteTest extends PHPUnit_Framework_TestCase
{
    public function testRewrite(){
        $rewriten = v::with('whatever')->rewrite('rewriten')->value;
        $this->assertSame('rewriten', $rewriten);
    }

    public function testRewriteAlone(){
        $rewriten = v::rewrite('rewriten')->value;
        $this->assertSame('rewriten', $rewriten);
    }
}
