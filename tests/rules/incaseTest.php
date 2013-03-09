<?php
use ValidatorInvoker as v;

class incaseTest extends PHPUnit_Framework_TestCase
{
     public function testIncase(){
        $first = v::with('whatever')->incase(v::valTrue(), v::modRewrite('first'), v::pass())->value;
        $this->assertSame('first', $first);

        $second = v::with('whatever')->incase(v::valFalse(),null, v::modRewrite('second'))->value;
        $this->assertSame('second', $second);

        $first = v::with('whatever')
            ->incase(
                v::valTrue(),
                v::modRewrite('first'),
                v::modRewrite('second')
            )
            ->value;

        $second = v::with('whatever')
            ->incase(
                v::valFalse(),
                v::modRewrite('first'),
                v::modRewrite('second')
            )
            ->value;

        $this->assertSame('first', $first);
        $this->assertSame('second', $second);

        $first = v::with('whatever')
            ->incase(
                v::valTrue(),
                v::modRewrite('first'),
                v::modRewrite('second')
            )
            ->valEquals('second')
            ->valid;

        $second = v::with('whatever')
            ->incase(
                v::valFalse(),
                v::modRewrite('first'),
                v::modRewrite('second')
            )
            ->valEquals('second')
            ->valid;

        $this->assertFalse($first);
        $this->assertTrue($second);
    }

    public function testIncaseException(){
        $this->setExpectedException('exception');
        v::incase(null, v::pass(), v::pass());
        //@codeCoverageIgnoreStart
    }

    public function testIncaseNoException(){
        $will_NOT_fail = v::incase(v::pass(), null, null)->run();
    }
}
