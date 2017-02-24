# PHP Helpers

[![Build Status](https://travis-ci.org/svil4ok/php-helpers.svg?branch=master)](https://travis-ci.org/svil4ok/php-helpers)

## String Helpers

<strong>`Str::contains`</strong>

> Check if a string contains another string/set of strings (case-sensitive).**

```php
$contains = Helpers\Str::contains('This is an example string', 'example');

var_dump($contains); // (bool) true

$contains = Helpers\Str::contains('This is an example string', ['not exists', 'example']);

var_dump($contains); // (bool) true
```

<strong>`Str::startsWith`</strong>

> Check if a given string starts with a given substring (case-sensitive).

```php
$startsWith = Helpers\Str::startsWith('This is an example string', 'This is');

var_dump($contains); // (bool) true

$startsWith = Helpers\Str::startsWith('This is an example string', 'this is');

var_dump($contains); // (bool) false
```

<strong>`Str::endsWith`</strong>

> Check if a given string ends with a given substring (case-sensitive).

```php
$endsWith = Helpers\Str::endsWith('This is an example string', 'example string');

var_dump($endsWith); // (bool) true

$endsWith = Helpers\Str::endsWith('This is an example string', 'Example string');

var_dump($endsWith); // (bool) false
```

<strong>`Str::length`</strong>

> Get string length.

```php
$length = Helpers\Str::length('This is an example string');

var_dump($length); // (int) 25
```

<strong>`Str::slug`</strong>

> Returns URL friendly slug version of input string:
> - converts all alpha chars to lowercase
> - converts any char that is not digit, letter or - into - symbols into "-"
> - not allow two "-" chars continued, converte them into only one syngle "-"

```php
$string = Helpers\Str::slug('This iS a sImpLe TEST');

var_dump($string); // (string) 'this-is-a-simple-tests'
```

## Array Helpers

<strong>`Arr::trim`</strong>

> Trims each array element.

```php
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

$arr = Helpers\Arr::trim($arr);

var_dump($arr);

/*
(array) [
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
*/
```

<strong>`Arr::removeEmpty`</strong>

> Removes empty elements from the array.

```php
$arr = [
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

$arr = Helpers\Arr::removeEmpty($arr);

var_dump($arr);

/*
(array) [
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
*/
```

<strong>`Arr::toArray`</strong>

> Convert a object to an array.<br /><br />
> **Imporant:** if the object has "toArray()" method then the result of it will be returned.

```php
$data = new \stdClass();
$data->foo = 'bar';
$data->bar = new \stdClass();
$data->bar->baz = 'some value';

$arr = Helpers\Arr::toArray($data);

var_dump($arr);

/*
(array) [
    'foo' => 'bar',
    'bar' => [
        'baz' => 'some value',
    ]
];
*/
```

<strong>`Arr::flatten`</strong>

> Convert multi-dimensional array into a flat array with hyphen-separated keys.

```php
$arr = [
    'employee' => [
        'id' => 1,
        'position' => [
            'name' => 'PHP Developer',
            'code' => 'php-dev'
        ]
    ],
    'active' => true
];

$separator = '-';

$arr = Helpers\Arr::flatten($data, $separator);

var_dump($arr);

/*
(array) [
    'employee-id' => 1,
    'employee-position-name' => 'PHP Developer',
    'employee-position-code' => 'php-dev',
    'active' => true
];
*/
```

<strong>`Arr::isAssoc`</strong>

> Determine if array is associative.

```php
$arr = [1, 2, 3];

$isAssoc = Helpers\Arr::isAssoc($arr);

var_dump($isAssoc); // (bool) false

$arr = [
    'key' => 'value',
    'foo' => [
        'bar' => 'baz'
    ],
    'oi' => 2
];

$isAssoc = Helpers\Arr::isAssoc($arr);

var_dump($isAssoc); // (bool) true
```
