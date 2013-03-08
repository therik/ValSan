<?php
use ValidatorInvoker as v;

class incaseTest extends PHPUnit_Framework_TestCase
{
     public function testIncase(){
        $first = v::incase(v::valTrue(), v::modRewrite('first'), v::pass())->run('whatever')->result;
        $this->assertSame('first', $first);

        $second = v::incase(v::valFalse(),null, v::modRewrite('second'))->run('whatever')->result;
        $this->assertSame('second', $second);

        $first = v::
            incase(
                v::valTrue(),
                v::modRewrite('first'),
                v::modRewrite('second')
            )
            ->run('whatever')
            ->result;

        $second = v::
            incase(
                v::valFalse(),
                v::modRewrite('first'),
                v::modRewrite('second')
            )
            ->run('whatever')
            ->result;

        $this->assertSame('first', $first);
        $this->assertSame('second', $second);

        $first = v::
            incase(
                v::valTrue(),
                v::modRewrite('first'),
                v::modRewrite('second')
            )
            ->valEquals('second')
            ->run('whatever')
            ->valid;

        $second = v::
            incase(
                v::valFalse(),
                v::modRewrite('first'),
                v::modRewrite('second')
            )
            ->valEquals('second')
            ->run('whatever')
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
        $will_NOT_fail = v::incase(v::pass(), null, null)->run('foobar');
    }
}
