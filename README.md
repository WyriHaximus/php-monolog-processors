# Middleware that removes the raw body from the request

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

## KeyValueProcessor(string $key, $value)

Add a fixed value for a fixed key into the `extra` array of the record. For example:

```php
new KeyValueProcessor('version', 'v1.33.128');
```

## RuntimeProcessor

Add `runtime` into `extra` array of the record with `microtime(true)` since creation of `RuntimeProcessor`. For example:

```php
new KeyValueProcessor();
```

## ToContextProcessor(array $keys = ['channel', 'extra', 'datetime'])

Copy the given items in the record array `context` item. For example:

```php
new ToContextProcessor();
```

# License

The MIT License (MIT)

Copyright (c) 2017 Cees-Jan Kiewiet

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
