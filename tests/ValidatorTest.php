<?php
use ValidatorInvoker as v;

class ValidatorTest extends PHPUnit_Framework_TestCase
{
    public function testValidator(){
        $val = v::valTrue('asd');
        $this->assertTrue($val->pass()->run('asd')->valid);
        $this->assertSame('whatever', $val->pass()->run('whatever')->result);

    }

    public function testNot(){
        $true = v::not(v::valFalse())->run('whatever')->valid;
        $this->assertTrue($true);
        $false = v::not(v::valTrue())->run('whatever')->valid;
        $this->assertFalse($false);
    }

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

    public function testStop(){
        $data = v::pass()->pass()->stop()->modRewrite('rewriten')->run('data')->result;
        $this->assertSame('data', $data);
    }


}

