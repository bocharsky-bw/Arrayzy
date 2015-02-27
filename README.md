# Arrayzy

A PHP array easy manipulation library in OOP way.

[![Build Status](https://travis-ci.org/bocharsky-bw/Arrayzy.svg?branch=master)](https://travis-ci.org/bocharsky-bw/Arrayzy)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e0235f5d-a89b-4add-b3c6-45813d2bf9eb/mini.png)](https://insight.sensiolabs.com/projects/e0235f5d-a89b-4add-b3c6-45813d2bf9eb)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bocharsky-bw/Arrayzy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bocharsky-bw/Arrayzy/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/bocharsky-bw/Arrayzy/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/bocharsky-bw/Arrayzy/?branch=master)

* [Installation](#installation)
* [Creation](#creation)
* [Usage](#usage)
    * [Chaining](#chaining)
* [Public method list](#public-method-list)
    * [chunk](#chunk)
    * [clear](#clear)
    * [combine](#combine)
    * [contains](#contains)
    * [containsKey](#containskey)
    * [count](#count)
    * [create](#create)
    * [createClone](#createclone)
    * [createFromJson](#createfromjson)
    * [createFromObject](#createfromobject)
    * [createFromString](#createfromstring)
    * [createWithRange](#createwithrange)
    * current
    * customSort
    * customSortKeys
    * debug
    * diff
    * dump
    * each
    * export
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
    * [reindex](#reindex)
    * [replace](#replace)
    * [reverse](#reverse)
    * [shift](#shift)
    * [shuffle](#shuffle)
    * [slice](#slice)
    * [sort](#sort)
    * [sortKeys](#sortkeys)
    * [toArray](#toarray)
    * [toJson](#tojson)
    * [toString](#tostring)
    * [unique](#unique)
    * [unshift](#unshift)
    * [walk](#walk)
* [Links](#links)

> **NOTE:** Each functional method operate on the same array and return same instance
(DO NOT create a new instance) except only few methods `start` with create prefix.
This way a bit improve performance and provide more convenience usage in OOP way.
Check the [CreateClone](#createclone) section if you want to operate on new instance NOT on same instance.


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
* [createFromJson](#createfromjson)
* [createFromObject](#createfromobject)
* [createFromString](#createfromstring)
* [createWithRange](#createwithrange)

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
    ->offsetSet(null, 'e')
    ->shuffle()
    ->reindex()// or any other method that return the current instance
;

$a->toArray(); // [0 => 'c', 1 => 'a', 2 => 'e', 3 => 'd', 4 => 'b']
```

### Converting

Easily converting instance elements to an array/json/string format:

* [toArray](#toarray)
* [toJson](#tojson)
* [toString](#tostring)

### Debugging

* [debug](#debug)
* [dump](#dump)
* [export](#export)

## Public method list

### Chunk

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->chunk(2);
$a->toArray(); // [0 => [0 => 'a', 1 => 'b'], 1 => [0 => 'c']]
```

### Clear

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->clear();
$a->toArray(); // []
```

### Combine

``` php
$a = MutableArray::create([1, 2, 3]);
$a->combine(['a', 'b', 'c']);
$a->toArray(); // [1 => 'a', 2 => 'b', 3 => 'c']
```

### Contains

``` php
$a = MutableArray::create(['a', 'b', 'c']);
print $a->contains('c'); // true
```

### ContainsKey

``` php
$a = MutableArray::create(['a', 'b', 'c']);
print $a->containsKey(2); // true
```

### Count

``` php
$a = MutableArray::create(['a', 'b', 'c']);
print $a->count(); // 3
```

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

### CreateClone

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

### Reindex

``` php
$a = MutableArray::create([2 => 'a', 1 => 'b', 3 => 'c']);
$a->reindex();
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### Replace

``` php
$a = MutableArray::create(['a', 'd', 'e']);
$a->replace([1 => 'b', 2 => 'c']);
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### Reverse

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->reverse();
$a->toArray(); // [0 => 'c', 1 => 'b', 2 => 'a']
```

### Shift

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->shift();
$a->toArray(); // [0 => 'b', 1 => 'c']
```

### Shuffle

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->shuffle();
$a->toArray(); // [0 => 'c', 1 => 'a', 2 => 'b']
```

### Slice

``` php
$a = MutableArray::create(['a', 'b', 'c', 'd']);
$a->slice(1, 2);
$a->toArray(); // [0 => 'b', 1 => 'c']
```

### Sort

``` php
$a = MutableArray::create(['b', 'a', 'd', 'c']);
$a->sort(SORT_DESC);
$a->toArray(); // [0 => 'd', 1 => 'c', 2 => 'b', 3 => 'a']
```

### SortKeys

``` php
$a = MutableArray::create([3 => 'a', 1 => 'b', 2 => 'c', 0 => 'd']);
$a->sortKeys(SORT_ASC);
$a->toArray(); // [0 => 'd', 1 => 'b', 2 => 'c', 3 => 'a']
```

### toArray

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### toJson

``` php
$a = MutableArray::create(['a' => 1, 'b' => 2, 'c' => 3]);
print $a->toJson(); // { "a": 1, "b": 2, "c":3 }
```

### toString

``` php
$a = MutableArray::create(['a', 'b', 'c']);
print $a->toString('-'); // 'a-b-c'
```

### Unique

``` php
$a = MutableArray::create(['a', 'b', 'b', 'c']);
$a->unique();
$a->toArray(); // [0 => 'a', 1 => 'b', 3 => 'c']
```

### Unshift

``` php
$a = MutableArray::create(['b', 'c']);
$a->unshift('a');
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### Walk

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->walk(function(&$value, $key) { //  
    $key++; // the $key variable passed by value, (original value will not modified)
    $value = $value . $key; // the $value variable passed by reference (modify original value)
});
$a->toArray(); // [0 => 'a1', 1 => 'b2', 2 => 'c3']
```

More docs will be added soon...

## Links

Look at the [Stringy](https://github.com/danielstjules/Stringy) if you are looking for a PHP string manipulation library in OOP way.
