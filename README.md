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
    * [current](#current)
    * [customSort](#customsort)
    * [customSortKeys](#customsortkeys)
    * [debug](#debug)
    * [diff](#diff)
    * [dump](#dump)
    * [each](#each)
    * [export](#export)
    * [filter](#filter)
    * [first](#first)
    * [flip](#flip)
    * getIterator
    * [getKeys](#getkeys)
    * [getRandom](#getrandom)
    * [getValues](#getvalues)
    * [indexOf](#indexof)
    * [isEmpty](#isempty)
    * [key](#key)
    * [last](#last)
    * [map](#map)
    * [merge](#merge)
    * [next](#next)
    * [offsetExists](#offsetexists)
    * [offsetGet](#offsetget)
    * [offsetSet](#offsetset)
    * [offsetUnset](#offsetunset)
    * [pad](#pad)
    * [pop](#pop)
    * [previous](#previous)
    * [push](#push)
    * [reduce](#reduce)
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

### chunk

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->chunk(2);
$a->toArray(); // [0 => [0 => 'a', 1 => 'b'], 1 => [0 => 'c']]
```

### clear

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->clear();
$a->toArray(); // []
```

### combine

``` php
$a = MutableArray::create([1, 2, 3]);
$a->combine(['a', 'b', 'c']);
$a->toArray(); // [1 => 'a', 2 => 'b', 3 => 'c']
```

### contains

``` php
$a = MutableArray::create(['a', 'b', 'c']);
print $a->contains('c'); // true
```

### containsKey

``` php
$a = MutableArray::create(['a', 'b', 'c']);
print $a->containsKey(2); // true
```

### count

``` php
$a = MutableArray::create(['a', 'b', 'c']);
print $a->count(); // 3
```

### create

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### createClone

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

### createFromJson

``` php
$a = MutableArray::createFromJson('{"a": 1, "b": 2, "c": 3}');
$a->toArray(); // ['a' => 1, 'b' => 2, 'c' => 3]
```

### createFromObject

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$b = MutableArray::createFromObject($a); // $a could be any object that implemented \ArrayAccess interface
$b->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### createFromString

``` php
$a = MutableArray::createFromString('a;b;c', ';');
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### createWithRange

``` php
$a = MutableArray::createWithRange(2, 6, 2);
$a->toArray(); // [0 => 2, 1 => 4, 2 => 6]
```

### current

``` php
$a = MutableArray::create(['a', 'b', 'c']);
print $a->current(); // 'a'
```

### customSort

``` php
$a = MutableArray::create(['b', 'a', 'c']);
$a->customSort(function($a, $b) {
    if ($a == $b) {
        return 0;
    }

    return ($a < $b) ? -1 : 1;
});
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### customSortKeys

``` php
$a = MutableArray::create([1 => 'b', 0 => 'a', 2 => 'c']);
$a->customSortKeys(function($a, $b) {
    if ($a == $b) {
        return 0;
    }

    return ($a < $b) ? -1 : 1;
});
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### debug

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->debug(); // Array ( [0] => a [1] => b [2] => c )
```

### diff

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->diff(['c', 'd']);
$a->toArray(); // [0 => 'a', 1 => 'b']
```

### dump

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->dump(); // array(3) { [0]=> string(1) "a" [1]=> string(1) "b" [2]=> string(1) "c" }
```

### each

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->each(); // [0 => 0, 'key' => 0, 1 => 'a', 'value' => 'a']
```

### export

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->export(); // array ( 0 => 'a', 1 => 'b', 2 => 'c', )
```

### filter

``` php
$a = MutableArray::create(['a', 'z', 'b', 'z']);
$a->filter(function($value) {
    return 'z' != $value; // exclude 'z' value from array 
});
$a->toArray(); // [0 => 'a', 2 => 'b']
```

### first

``` php
$a = MutableArray::create(['a', 'b', 'c']);
print $a->first(); // 'a'
```

### flip

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->flip();
$a->toArray(); // ['a' => 0, 'b' => 1, 'c' => 2]
```

### getKeys

``` php
$a = MutableArray::create(['a' => 1, 'b' => 2, 'c' => 3]);
$a->getKeys(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### getRandom

``` php
$a = MutableArray::create(['a', 'b', 'c', 'd']);
print $a->getRandom(); // 'c'
```

### getValues

``` php
$a = MutableArray::create([1 => 'a', 2 => 'b', 3 => 'c']);
$a->getValues(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### indexOf

``` php
$a = MutableArray::create(['a', 'b', 'c']);
print $a->indexOf('b'); // 1 
```

### isEmpty

``` php
$a = MutableArray::create([]);
$a->isEmpty(); // true
```

### key

``` php
$a = MutableArray::create(['a', 'b', 'c']);
print $a->current(); // 'a'
print $a->key(); // 0
print $a->next(); // 'b'
print $a->key(); // 1
```

### last

``` php
$a = MutableArray::create(['a', 'b', 'c']);
print $a->last(); // 'c'
```

### map

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->map(function($value) {
    return $value . $value;
});
$a->toArray(); // [0 => 'aa', 1 => 'bb', 2 => 'cc']
```

### merge

``` php
// indexed array behavior
$a = MutableArray::create(['a', 'b', 'c']); // indexed array
$a->merge(['c', 'd']); // [0 => 'a', 1 => 'b', 2 => 'c', 3 => 'c', 4 => 'd']

// assoc array behavior
$b = MutableArray::create(['a' => 1, 'b' => 2, 'c' => 99]);
$b->merge(['c' => 3, 'd' => 4]); // ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
```

### next

``` php
$a = MutableArray::create(['a', 'b', 'c']);
print $a->next(); // 'b'
print $a->next(); // 'c'
```

### offsetExists

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->offsetExists(2); // true (or isset($a[2]))
$a->offsetExists(3); // false (or isset($a[3]))
```

### offsetGet

``` php
$a = MutableArray::create(['a', 'b', 'c']);
print $a->offsetGet(1); // 'b' (or $a[1])
```

### offsetSet

``` php
$a = MutableArray::create(['a', 'b', 'd']);
// add new value
$a->offsetSet(null, 'd'); // or $a[] = 'd';
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'd', 3=> 'd']
// replace existing value by key
$a->offsetSet(2, 'c'); // or $a[2] = 'c';
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c', 3=> 'd']
```

### offsetUnset

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->offsetUnset(1); // or unset($a[1]);
$a->toArray(); // [0 => 'a', 2 => 'c']
```

### pad

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->pad(5, 'z');
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c', 3 => 'z', 4 => 'z']
```

### pop

``` php
$a = MutableArray::create(['a', 'b', 'c']);
print $a->pop(); // 'c'
$a->toArray(); // [0 => 'a', 1 => 'b']
```

### previous

``` php
$a = MutableArray::create(['a', 'b', 'c']);
print $a->next(); // 'b'
print $a->next(); // 'c'
print $a->previous(); // 'b'
```

### push

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->push('d');
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c', 3 => 'd']
```

### reduce

``` php
$a = MutableArray::create(['a', 'b', 'c']);
print $a->reduce(function($result, $item) {
    return $result . $item;
}); // 'abc'
```

### reindex

``` php
$a = MutableArray::create([2 => 'a', 1 => 'b', 3 => 'c']);
$a->reindex();
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### replace

``` php
$a = MutableArray::create(['a', 'd', 'e']);
$a->replace([1 => 'b', 2 => 'c']);
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### reverse

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->reverse();
$a->toArray(); // [0 => 'c', 1 => 'b', 2 => 'a']
```

### shift

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->shift();
$a->toArray(); // [0 => 'b', 1 => 'c']
```

### shuffle

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->shuffle();
$a->toArray(); // [0 => 'c', 1 => 'a', 2 => 'b']
```

### slice

``` php
$a = MutableArray::create(['a', 'b', 'c', 'd']);
$a->slice(1, 2);
$a->toArray(); // [0 => 'b', 1 => 'c']
```

### sort

``` php
$a = MutableArray::create(['b', 'a', 'd', 'c']);
$a->sort(SORT_DESC);
$a->toArray(); // [0 => 'd', 1 => 'c', 2 => 'b', 3 => 'a']
```

### sortKeys

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

### unique

``` php
$a = MutableArray::create(['a', 'b', 'b', 'c']);
$a->unique();
$a->toArray(); // [0 => 'a', 1 => 'b', 3 => 'c']
```

### unshift

``` php
$a = MutableArray::create(['b', 'c']);
$a->unshift('a');
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### walk

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->walk(function(&$value, $key) { //  
    $key++; // the $key variable passed by value, (original value will not modified)
    $value = $value . $key; // the $value variable passed by reference (modify original value)
});
$a->toArray(); // [0 => 'a1', 1 => 'b2', 2 => 'c3']
```

## Links

Feel free to create [issue](https://github.com/bocharsky-bw/Arrayzy/issues) or [pull request](https://github.com/bocharsky-bw/Arrayzy/pulls)
if you find a bug or just want to propose improvement suggestion

Look at the [Stringy](https://github.com/danielstjules/Stringy) if you are looking for a PHP **string** manipulation library in OOP way.
