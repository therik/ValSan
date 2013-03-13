<?php
use ValidatorInvoker as v;

class incaseTest extends PHPUnit_Framework_TestCase
{
    public function testTrueFalsePassingValue(){
        // $this->markTestSkipped();
        $first = v::
            with('whatever')->
            incase(
                v::true(),
                v::rewrite('first'),
                null
            )->value;
        $this->assertSame('first', $first);

        $second = v::
            with('whatever')->
            incase(
                v::false(),
                null,
                v::rewrite('second')
            )->value;
        $this->assertSame('second', $second);
    }

    public function testIncase(){
        $first = v::with('whatever')
            ->incase(
                v::true(),
                v::rewrite('first'),
                v::rewrite('second')
            )
            ->value;
        $this->assertSame('first', $first);

        $second = v::with('whatever')
            ->incase(
                v::false(),
                v::rewrite('first'),
                v::rewrite('second')
            )
            ->value;

        $this->assertSame('second', $second);

        $first = v::with('whatever')
            ->incase(
                v::true(),
                v::rewrite('first'),
                v::rewrite('second')
            )
            ->equals('second')
            ->valid;

        $second = v::with('whatever')
            ->incase(
                v::false(),
                v::rewrite('first'),
                v::rewrite('second')
            )
            ->equals('second')
            ->valid;

        $this->assertFalse($first);
        $this->assertTrue($second);
    }

    public function testConditionNotPassingValue(){
        $this->assertSame('something',
                          v::with('something')->
                          incase(v::rewrite('else'),
                                 v::pass(),
                                 v::pass())->value
                         );

    }

    public function testBoolBeforeIncase(){
        $val = v::false()->
            incase(
                v::pass(),
                v::rewrite('Wrong'),
                v::rewrite('Right')
            );
        $this->assertSame('Right', $val->value);
    }

    public function testIncaseException(){
        // $this->markTestSkipped();
        $this->setExpectedException('exception');
        v::incase(null, v::pass(), v::pass());
        //@codeCoverageIgnoreStart
    }

    public function testIncaseNoException(){
        // $this->markTestSkipped();
        $will_NOT_fail = v::incase(v::pass(), null, null)->run();
    }

    public function testNotStoppedInCondition(){
        $val = v::
            incase(v::true()->stop()->false(),
                v::rewrite('true'),
                v::rewrite('false')
            );
        $this->assertTrue($val->valid);
        $this->assertSame('true', $val->value);

        $val = v::
            incase(v::false()->stop()->true(),
                v::rewrite('true'),
                v::rewrite('false')
            );

        $this->assertTrue($val->valid);
        $this->assertSame('false', $val->value);

        $val = v::
            incase(v::true()->stop()->false(),
                v::rewrite('true'),
                v::rewrite('false')
            )
            ->rewrite('valid');

        $this->assertTrue($val->valid);
        $this->assertSame('valid', $val->value);

    }
}
