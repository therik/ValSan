<?php
use ValidatorInvoker as v;

class keyTest extends PHPUnit_Framework_TestCase
{
    public function testPassSpecifiedKey(){
        // $this->markTestIncomplete();
        // $this->markTestSkipped();
        $val1 = v::
            with(array('key' => 'value'))
            ->arr(v::key(v::same('key'))
            );
        $this->assertSame(array('key' => 'value'), $val1->value);
        $this->assertTrue($val1->valid);
    }

    public function testNotPassAnything(){
        $v = v::
            with(array('anykey' => 'value'))
            ->arr(v::key()->false());

        $this->assertFalse($v->valid);

        // should not change value
        $this->assertSame(array('anykey' => 'value'), $v->value);
    }


    public function testKey(){
        // $this->markTestIncomplete();
        // $this->markTestSkipped();
        $true = v::with(array('validKey' => 'whatever'))
            ->arr(v::key(v::same('validKey'),
                  v::key()->false())
            )
            ->valid;

        $false = v::with(array('invalid' => 'whatever'))
            ->arr(v::key(v::same('validKey')),
                  v::key()->false())
            ->valid;

        $this->assertTrue($true);
        $this->assertFalse($false);
    }

    public function testKeyDontChange(){
        // $this->markTestIncomplete();
        // $this->markTestSkipped();
        $array = v::with(array('validKey' => 'whatever'))
            ->arr(v::key(v::same('validKey')));

        $this->assertArrayHasKey('validKey', $array->value);


        $array = v::with(array('invalid' => 'whatever'))
            ->arr(
                v::key(v::same('validKey')));

        $this->assertArrayHasKey('invalid', $array->value);


        $array = v::with(array('unchanged' => 'whatever'))
            ->arr(
                v::key(v::same('unchanged')->rewrite('blah')));

        $this->assertArrayHasKey('unchanged', $array->value);
    }

}
