<?php
use ValidatorInvoker as v;

class PregTest extends PHPUnit_Framework_TestCase
{
    public function testValPreg(){
        $true = v::with('numbers: 225652')->valPreg('/^numbers: \d+$/')->valid;
        $false = v::with('numbers: 16.52')->valPreg('/^numbers: \d+$/')->valid;

        $this->assertTrue($true);
        $this->assertFalse($false);
    }

    public function testModPreg(){
        $tenDigitsSanitized = v::with("  01 .2kjfa3nasfoiao4 /*-/\n\n bleeh 5 !@#$%^&* 6789")->modPreg('/\D/')->value;
        $this->assertSame('0123456789', $tenDigitsSanitized);

        $preg_replacedE = v::with('pr1g_r#$%(plac||||dE')->modPreg('/[^a-zA-Z_]+/', 'e')->value;
        $this->assertSame('preg_replacedE', $preg_replacedE);
    }
}
