ValSan
======

A bunch of php that validates and sanitizes input.



usage v-double-colon:
<?php
use ValidatorInvoker as v;
v::pass();
?>

Validator properties
$valid // true if evaluated chain is valid (if all validations were valid)
$value // value at the end of the chain
$stop // true, if the chain evaluation was enforced to stop
 !! Reading any of those properties automatically evaluates the chain, if it wasn't evaluated yet with current value !!


Main validator methods:
with(mixed $value) // assigns new $value into validator object and resets objects internal state
pass() // dummy method does nothing, except returns the validator object
run() // manually (re)evaluate the chain

Trivial rules:
true() // sets internal $valid flag to true
false() // sets internal $valid flag to false

equals($value) // loosely compares chain's current internal value to $value and sets $valid flag false if those aren't same
same($value) // same as equals() but strict comparing

rewrite($new_value) // rewrites chains internal value to $new_value

Examples:
// theese are default (useless examples)
v::pass()->valid // true
v::pass()->value // null

// overwriting valid flag (alone useless)
v::true()->valid // true
v::false()->valid // false

// simple 'equals' use
v::with('foo')->equals('foo')->valid; // true
v::with('foo')->equals('bar')->valid; // false

// 'equals' doesn't change value
v::with('foo')->equals('foo')->value // 'foo'
v::with('foo')->equals('bar')->value // 'foo' valid is false, but value doesn't change

// simple rewrite
v::with('foo')->rewrite('bar')->value // 'bar'

// chain of rewrites, all 'equals' evaluate to true, but internal $value changes after each $rewrite
v::with('a')->rewrite('b')->equals('b')->rewrite('c')->equals('c')->rewrite('d')->equals('d')->valid // true



//reuse of chain
$validator = v::equals('foo');
$validator->with('foo')->valid; // true
$validator->with('bar')->valid; // false

//or with 'with' in the definition
$validator = v::with('foo')->equals('foo');
$validator->valid; // true
$validator->with('bar')->valid; // false

Chain reuse behavior explanation:
- Chain starts with internal state $ran=false,
- reading $valid, $value or $stop properties launches the run() method only if the $ran state was false
- run() method evaluates the chain and sets $ran to true
- with() method resets the $ran state back to false (and assigns new initial value)

// therefore in this case, the chain runs only once
    $val = v::with('whatever')->really_really_long_and_expensive_chain()
    $val->valid;
    $val->valid;
    $val->value;
    $val->value;
    $val->value;



RULES:
v::not(chain $subchain)
sets the current $valid property of chain to opposite of $subchain->valid
ex:
v::not(v::true())->valid // false

v::oneOf($value1, $value2, ...)
evaluates to true if one of parameters matches current internal $value
ex:
$val = v::oneOf('a', 'b', 'foo');
$val->with('foo')->valid // true
$val->with(12345)->valid; // false

v::incase(chain $condition, chain $trueChain, chain $falseChain)
sort of like ternary if, or rather like 'if' in regular expressions
if $condition->valid is true, evaluation continues through $trueChain, $falseChain otherwise
note: $condition doesn't return any result values or $stop flag, nor it changes anything back to main chain

ex:
$val = v::incase(v::equals('a'), v::rewrite('b') , v::pass())
$val->with('a')->value // b (rewritten in trueChain)
$val->with('b')->value // b (but not rewritten anywhere, falseChain does nothing)
$val->with('c')->value // c (not rewritten either)

another example:
$val = v::incase(v::oneOf('man', 'woman', 'child'),
                 v::pass(),
                 v::rewrite('unspecified')->false()
                 );

$val->with('man')->valid // true
$val->value // 'man'

$val->with('invalid user input')->valid // false
$va->value // unspecified

$val->with('woman')->valid // true
$val->value // 'woman'


v::stop()
rule that immediately stopps current evaluation
examples:
v::with('a')->rewrite('b')
            ->stop()
            ->rewrite('c')
            ->rewrite('d')
            ->value // b

v::with('asd')->incase(v::true(), v::stop() v::pass())->rewrite('bbbbb')->value // 'asd' (chain stooped in incase's true-subchain)

note: if the stop() in condition subchain of incase, it doesn't stop the whole chain, just the condition branch


Array rules:
are pretty much mess right now

The idea was to make ordered list of possible subchain rules that can attempt match the key value in specified order, sort of like iptables or apaches mod_rewrite rules work.
First subchain that matches the key-value twin has the right to do whatever it wants to do with it. (change value, remove from array, etc..)
but, that's still messy now, check tests of arr, key and count rules to see what's there...

<?
