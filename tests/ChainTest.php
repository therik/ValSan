<?php
use ValidatorInvoker as v;

class ChainTest extends PHPUnit_Framework_TestCase
{
    public function testChain(){
        // $this->markTestSkipped();
        $chain = Validator::getChainObject(v::true()->false()->equals('fsd')->same('asd'));

        $this->assertTrue($chain->containsRule('true'));
        $this->assertTrue($chain->containsRule('false'));
        $this->assertTrue($chain->containsRule('equals'));
        $this->assertTrue($chain->containsRule('same'));

        $this->assertFalse($chain->containsRule('arr'));
        $this->assertFalse($chain->containsRule('key'));
        $this->assertFalse($chain->containsRule('NonExistingRule'));
        $this->assertFalse($chain->containsRule('blablabla'));
        $this->assertFalse($chain->containsRule(1123.15));
        $this->assertFalse($chain->containsRule(new stdClass));
        $this->assertFalse($chain->containsRule(null));
    }

    public function testEmptyType(){
        // $this->markTestSkipped();
        // $this->markTestIncomplete();
        $chain = Validator::getChainObject(v::pass());

        $this->assertSame('', $chain->getType());

        $this->assertTrue($chain->isOfType(''));
        $this->assertFalse($chain->isOfType('whatever'));
        $this->assertFalse($chain->isOfType('something-with-more-levels'));
    }

    public function testForcedType(){
        // $this->markTestSkipped();
        // $this->markTestIncomplete();
        $chain = Validator::getChainObject(v::pass());
        $chain->forceType('whatever-subtype');
        $this->assertSame('whatever-subtype', $chain->getType());
    }

    public function testIsOfType(){
        // $this->markTestSkipped();
        // $this->markTestIncomplete();
        $chain = Validator::getChainObject(v::pass());

        $this->assertTrue($chain->isOfType(''));

        $chain->forceType('some');
        $this->assertTrue($chain->isOfType(''));
        $this->assertTrue($chain->isOfType('some'));
        $this->assertFalse($chain->isOfType('som'));


        $chain->forceType('');
        $this->assertSame('', $chain->getType());

        $this->assertFalse($chain->isOfType('whatever'));
    }

    public function testTryType(){
        // $this->markTestSkipped();
        // $this->markTestIncomplete();
        $chain = Validator::getChainObject(v::pass());

        $this->assertTrue($chain->tryType(''));
        $this->assertSame('', $chain->getType());

        $this->assertTrue($chain->tryType('first'));
        $this->assertSame('first', $chain->getType());

        $this->assertTrue($chain->tryType('first'));
        $this->assertSame('first', $chain->getType());

        $this->assertTrue($chain->tryType(''));
        $this->assertSame('first', $chain->getType());

        $this->assertTrue($chain->tryType('first-second'));
        $this->assertSame('first-second', $chain->getType());

        $this->assertTrue($chain->tryType(''));
        $this->assertTrue($chain->tryType('first'));
        $this->assertSame('first-second', $chain->getType());

        $this->assertTrue($chain->tryType('first-second-third'));

        $this->assertTrue($chain->tryType(''));
        $this->assertTrue($chain->tryType('first'));
        $this->assertTrue($chain->tryType('first-second'));

        $this->assertSame('first-second-third', $chain->getType());
    }
}
