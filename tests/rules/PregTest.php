<?php
use ValidatorInvoker as v;

class PregTest extends PHPUnit_Framework_TestCase
{
    public function testValPreg(){
        $true = v::pass()->valPreg('/^numbers: \d+$/')->run('numbers: 225652')->valid;
        $false = v::pass()->valPreg('/^numbers: \d+$/')->run('numbers: 16.52')->valid;

        $this->assertTrue($true);
        $this->assertFalse($false);
    }

    public function testModPreg(){
        $tenDigitsSanitized = v::modPreg('/\D/')->run("  01 .2kjfa3nasfoiao4 /*-/\n\n bleeh 5 !@#$%^&* 6789")->result;
        $this->assertSame('0123456789', $tenDigitsSanitized);

        $preg_replacedE = v::modPreg('/[^a-zA-Z_]+/', 'e')->run('pr1g_r#$%(plac||||dE')->result;
        $this->assertSame('preg_replacedE', $preg_replacedE);
    }
}
