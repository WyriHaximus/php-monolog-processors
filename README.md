# Processors for Monolog

[![Build Status](https://travis-ci.org/WyriHaximus/php-monolog-processors.svg?branch=master)](https://travis-ci.org/WyriHaximus/php-monolog-processors)
[![Latest Stable Version](https://poser.pugx.org/WyriHaximus/monolog-processors/v/stable.png)](https://packagist.org/packages/WyriHaximus/monolog-processors)
[![Total Downloads](https://poser.pugx.org/WyriHaximus/monolog-processors/downloads.png)](https://packagist.org/packages/WyriHaximus/monolog-processors)
[![Code Coverage](https://scrutinizer-ci.com/g/WyriHaximus/php-monolog-processors/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/WyriHaximus/php-monolog-processors/?branch=master)
[![License](https://poser.pugx.org/WyriHaximus/monolog-processors/license.png)](https://packagist.org/packages/WyriHaximus/monolog-processors)
[![PHP 7 ready](http://php7ready.timesplinter.ch/WyriHaximus/php-monolog-processors/badge.svg)](https://travis-ci.org/WyriHaximus/php-monolog-processors)

# Install

To install via [Composer](http://getcomposer.org/), use the command below, it will automatically detect the latest version and bind it with `^`.

```
composer require wyrihaximus/monolog-processors
```

# Processors

## CopyProcessor()

Copies a value from the location in the first argument to the location in the second argument in the record array. 

```php
new CopyProcessor('context.abc', 'context.def');
```

So the following record:

```php
$record = [
    'context' => [
        'abc' => 'value',
    ],
];
```

Becomes: 

```php
$record = [
    'context' => [
        'abc' => 'value',
        'def' => 'value',
    ],
];
```

## ExceptionClassProcessor()

When encountering a throwable in `context.exception` it adds the class name into `context.exception_class`: 

```php
new ExceptionClassProcessor();
```

## KeyValueProcessor(string $key, $value)

Add a fixed value for a fixed key into the `extra` array of the record. For example:

```php
new KeyValueProcessor('version', 'v1.33.128');
```

## RuntimeProcessor

Add `runtime` into `extra` array of the record with `microtime(true)` since creation of `RuntimeProcessor`. For example:

```php
new RuntimeProcessor();
```

## ToContextProcessor(array $keys = ['channel', 'extra', 'datetime'])

Copy the given items in the record array `context` item. For example:

```php
new ToContextProcessor();
```

## TraceProcessor()

Adds `trace` into `extra` with the contents of `debug_backtrace` (when true is passed into the constructor) or `Throwable::getTrace` without the arguments.

```php
new TraceProcessor();
```

# License

The MIT License (MIT)

Copyright (c) 2022 Cees-Jan Kiewiet

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
