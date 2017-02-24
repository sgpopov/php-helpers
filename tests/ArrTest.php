<?php

use Helpers\Arr;

class ArrTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @covers Arr::trim()
     */
    public function shouldTrimArray()
    {
        $arr = [
            'key1' => ' value      ',
            'key2' => "value \n",
            'key3' => "value \n\t",
            'key4' => "value \n\t\r",
            'key5' => [
                'key6' => '       Testing started           ',
                'key7' => [
                    'key9' => 'Testing started      '
                ],
                'key8' => [
                    ' value      ',
                    "value \n",
                    "value \n\t",
                    "value \n\t\r"
                ]
            ]
        ];

        $actual = Arr::trim($arr);
        $expected = [
            'key1' => 'value',
            'key2' => 'value',
            'key3' => 'value',
            'key4' => 'value',
            'key5' => [
                'key6' => 'Testing started',
                'key7' => [
                    'key9' => 'Testing started'
                ],
                'key8' => [
                    'value',
                    'value',
                    'value',
                    'value'
                ]
            ]
        ];

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     *
     * @covers Arr::isAssoc()
     */
    public function shouldDetermineIfArrayIsAssoc()
    {
        $arr = [1, 2, 3];

        $this->assertFalse(Arr::isAssoc($arr));

        $arr = ['1', 2, [
            'key' => 'value'
        ]];

        $this->assertFalse(Arr::isAssoc($arr));

        $arr = [
            'key' => 'value',
            'foo' => [
                'bar' => 'baz'
            ],
            'oi' => 2,
            3 => 'yep'
        ];

        $this->assertTrue(Arr::isAssoc($arr));
    }

    /**
     * @test
     *
     * @covers Arr::removeEmpty()
     */
    public function shouldRemoveEmptyElements()
    {
        $input = [
            1 => [
                'foo' => '',
                'bar' => 1,
                'baz' => 1
            ],
            2 => [
                'foo' => null,
                'bar' => null,
                'baz' => 0
            ],
            3 => [
                'foo' => null,
                'bar' => null,
                'pts_cg' => null
            ],
            'key' => [
                'foo' => '   ',
                'bar' => 1,
                'baz' => 1
            ]
        ];

        $actual = Arr::removeEmpty($input);
        $expected = [
            1 => [
                'bar' => 1,
                'baz' => 1
            ],
            2 => [
                'baz' => 0
            ],
            'key' => [
                'bar' => 1,
                'baz' => 1
            ]
        ];

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     *
     * @covers Arr::toArray()
     */
    public function shouldConvertObjectToArray()
    {
        $data = new \stdClass();
        $data->foo = 'bar';
        $data->bar = new \stdClass();
        $data->bar->baz = 'some value';

        $this->assertFalse(is_array($data));

        $actual = Arr::toArray($data);

        $this->assertNotInstanceOf(\stdClass::class, $actual);
        $this->assertTrue(is_array($actual));
        $this->assertArrayHasKey('bar', $actual);
        $this->assertTrue(is_array($actual['bar']));
        $this->assertArrayHasKey('baz', $actual['bar']);
    }

    /**
     * @test
     *
     * @covers Arr::flatten()
     */
    public function shouldFlattenArray()
    {
        $input = [
            'employee' => [
                'id' => 1,
                'position' => [
                    'name' => 'PHP Developer',
                    'code' => 'php-dev'
                ]
            ],
            'active' => true
        ];

        $expected = [
            'employee-id' => 1,
            'employee-position-name' => 'PHP Developer',
            'employee-position-code' => 'php-dev',
            'active' => true
        ];

        $this->assertSame($expected, Arr::flatten($input));

        $seprator = '.';

        $expected = [
            'employee.id' => 1,
            'employee.position.name' => 'PHP Developer',
            'employee.position.code' => 'php-dev',
            'active' => true
        ];

        $this->assertSame($expected, Arr::flatten($input, $seprator));
    }
}
