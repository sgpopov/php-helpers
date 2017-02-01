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

    /**
     * @test
     *
     * @covers Str::length()
     */
    public function shouldReturnStringLength()
    {
        $tests = [
            'this is easy' => 12,
            'tHiS        iS eASY' => 19,
            '<img src="image.png" />' => 23,
            'ä ö ü ß €' => 9,
            'TeRríbLé(!) STRinG' => 18,
            '!@~$%#^&()_+}{.;[]}"\'' => 21,
            '$ ₡ ₱ £ ¢ £ ₨' => 13
        ];

        foreach ($tests as $input => $expectedLength) {
            $this->assertSame($expectedLength, Str::length($input));
        }
    }

    /**
     * @test
     *
     * @covers Str::slug()
     */
    public function shouldCreateUrlSlug()
    {
        $tests = [
            'this is easy' => 'this-is-easy',
            'tHiS        iS eASY' => 'this-is-easy',
            'this--------is easy' => 'this-is-easy',
            '<img src="image.png" />' => 'img-src-image-png',
            'ä ö ü ß €' => 'a-o-u-sz', // the euro sign is ignored
            'TeRríbLé(!) STRinG' => 'terrible-string',
            '!@~$%#^&()_+}{.;\'[]}' => '',
            '$ ₡ ₱ £ ¢ £ ₨' => '',
        ];

        foreach ($tests as $input => $expected) {
            $this->assertSame($expected, Str::slug($input));
        }

        $this->assertSame('this.is.easy', Str::slug('this..........is easy', '.'));
    }
}
