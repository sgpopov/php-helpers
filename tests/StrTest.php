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
     * @covers Str::startsWith()
     */
    public function shouldCheckIfStringStartsWithSubstring()
    {
        $tests = [
            [
                'input' => 'This is a test',
                'startsWith' => '',
                'result' => true
            ],
            [
                'input' => 'tHiS        iS eASY',
                'startsWith' => 'this',
                'result' => false
            ],
            [
                'input' => '<img src="image.png" />',
                'startsWith' => 'img',
                'result' => false
            ],
            [
                'input' => '<img src="image.png" />',
                'startsWith' => '<img',
                'result' => true
            ],
            [
                'input' => 'ä ö ü ß €',
                'startsWith' => 'a',
                'result' => false
            ],
            [
                'input' => 'ä ö ü ß €',
                'startsWith' => 'ä',
                'result' => true
            ],
            [
                'input' => '!@~$%#^&()_+}{.;[]}"\'',
                'startsWith' => '!@~',
                'result' => true
            ]
        ];

        foreach ($tests as $test) {
            if ($test['result'] === true) {
                $this->assertTrue(Str::startsWith($test['input'], $test['startsWith']));
            } else {
                $this->assertFalse(Str::startsWith($test['input'], $test['startsWith']));
            }
        }
    }

    /**
     * @test
     *
     * @covers Str::endsWith()
     */
    public function shouldCheckIfStringEndsWithSubstring()
    {
        $tests = [
            [
                'input' => 'This is a test',
                'endsWith' => '',
                'result' => true
            ],
            [
                'input' => 'tHiS        iS eASY',
                'endsWith' => 'easy',
                'result' => false
            ],
            [
                'input' => '<img src="image.png" />',
                'endsWith' => '.png',
                'result' => false
            ],
            [
                'input' => '<img src="image.png" />',
                'endsWith' => '" />',
                'result' => true
            ],
            [
                'input' => 'ä ö ü',
                'endsWith' => 'u',
                'result' => false
            ],
            [
                'input' => 'ä ö ü',
                'endsWith' => 'ü',
                'result' => true
            ],
            [
                'input' => '!@~$%#^&()_+}{.;[]}"\'',
                'endsWith' => '"\'',
                'result' => true
            ]
        ];

        foreach ($tests as $test) {
            if ($test['result'] === true) {
                $this->assertTrue(Str::endsWith($test['input'], $test['endsWith']));
            } else {
                $this->assertFalse(Str::endsWith($test['input'], $test['endsWith']));
            }
        }
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
