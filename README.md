# Arrayzy

A PHP array easy manipulation library in OOP way.

[![Build Status](https://travis-ci.org/bocharsky-bw/Arrayzy.svg?branch=master)](https://travis-ci.org/bocharsky-bw/Arrayzy)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e0235f5d-a89b-4add-b3c6-45813d2bf9eb/mini.png)](https://insight.sensiolabs.com/projects/e0235f5d-a89b-4add-b3c6-45813d2bf9eb)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bocharsky-bw/Arrayzy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bocharsky-bw/Arrayzy/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/bocharsky-bw/Arrayzy/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/bocharsky-bw/Arrayzy/?branch=master)

* [Installation](#installation)
* [Creation](#creation)
* [Usage](#usage)
* [Public method list](#public-method-list)
    * chunk
    * clear
    * combine
    * contains
    * containsKey
    * count
    * create
    * createClone
    * createFromJson
    * createFromObject
    * createFromString
    * createWithRange
    * current
    * customSort
    * customSortKeys
    * diff
    * each
    * filter
    * first
    * flip
    * getIterator
    * getKeys
    * getRandom
    * getValues
    * indexOf
    * isEmpty
    * key
    * last
    * map
    * merge
    * next
    * offsetExists
    * offsetGet
    * offsetSet
    * offsetUnset
    * pad
    * pop
    * prev
    * push
    * reduce
    * replace
    * reverse
    * shift
    * shuffle
    * slice
    * sort
    * sortKeys
    * toArray
    * toJson
    * toString
    * unique
    * unshift
    * walk

## Installation

Install package with [Composer](https://getcomposer.org/):

``` bash
$ composer require bocharsky-bw/arrayzy:dev-master
```

or download library manually and require directly in script:

``` php
require_once __DIR__ . '/path/to/library/src/MutableArray.php';
```

Don't forget about namespace.
Use [namespace arbitrary alias](http://php.net/manual/en/language.namespaces.importing.php) for simplicity:

``` php
use Arrayzy\MutableArray as MuArr; // MuArr is the arbitrary alias
```

## Creation

Create a new empty object with the `new` statement:

``` php
$muArr = new MuArr;
```

or with default values, passed array to the constructor:

``` php
$muArr = new MuArr([1,2,3]);
```

Also, a new object can be created with one of few public `static` methods
that start with `create` prefix and provide additional useful functionality:

* [create](#create)
* [createFromJson](#createFromJson)
* [createFromObject](#createFromObject)
* [createFromString](#createFromString)
* [createWithRange](#createWithRange)

### Create

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### CreateFromJson

``` php
$a = MutableArray::createFromJson('{"a": 1, "b": 2, "c": 3}');
$a->toArray(); // ['a' => 1, 'b' => 2, 'c' => 3]
```

### CreateFromObject

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$b = MutableArray::createFromObject($a); // $a could be any object that implemented \ArrayAccess interface
$b->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### CreateFromString

``` php
$a = MutableArray::createFromString('a;b;c', ';');
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### CreateWithRange

``` php
$a = MutableArray::createWithRange(2, 6, 2);
$a->toArray(); // [0 => 2, 1 => 4, 2 => 6]
```

> **NOTE:** Each functional method operate on the same array and return same instance
(DO NOT create a new instance) except only few methods `start` with create prefix.
This way a bit improve performance and provide more convenience usage in OOP way.

Keep in mind, that in PHP variables contains only reference to the object, **NOT** the same object:

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$b = $a; // $a and $b are different variables referenced to the same object ($a === $b)
```

So if you **DO NOT** want to modify current instance, you need to clone it manually first:

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$b = clone $a; // $a and $b are different instances ($a !== $b)
// or do it with built-in method
$b = $a->createClone(); // $a !== $b
```

## Usage

You can access to the instance as to a simple PHP array

``` php
$a = MutableArray::create(['a', 'b', 'c']);

$a[] = 'e'; // or use $a->offsetSet(null, 'e') method
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c', 3 => 'e']

$a[3] = 'd'; // or use $a->offsetSet(3, 'd') method
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c', 3 => 'd']

print $a[1]; // 'b'
// or use corresponding method
print $a->offsetGet(1); // 'b'
```

### Chaining

Use chaining methods for fast usage:

``` php
$a = MutableArray::create(['a', 'b', 'c']);

$a
    ->offsetSet(null, 'e')
    ->offsetSet(3, 'd')
    ->offsetSet(null, 'e') // or any other method that return the current instance
;

$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c', 3 => 'd', 4 => 'e']
```

## Public method list

Docs will be added soon...

Look at the [Stringy](https://github.com/danielstjules/Stringy) if you are looking for a PHP string manipulation library in OOP way.
