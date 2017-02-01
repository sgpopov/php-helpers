<?php

use Helpers\Str;

class StrTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     *
     * @covers Str::contains()
     */
    public function shouldCheckIfStringContainsAnotherString()
    {
        $this->assertTrue(Str::contains('this is a string', 'string'));
        $this->assertTrue(Str::contains('this is a string', 'this'));
        $this->assertTrue(Str::contains('this is a string', 'a'));
        $this->assertTrue(Str::contains('this is a string', ' '));

        $this->assertTrue(Str::contains('this is a string', [
            'not exists', 'string'
        ]));

        $this->assertFalse(Str::contains('this is a string', 'not exists'));
        $this->assertFalse(Str::contains('this is a string', [
            'not exists'
        ]));
    }
}
