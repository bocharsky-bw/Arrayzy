# Arrayzy

A native PHP arrays easy manipulation library in OOP way.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e0235f5d-a89b-4add-b3c6-45813d2bf9eb/mini.png)](https://insight.sensiolabs.com/projects/e0235f5d-a89b-4add-b3c6-45813d2bf9eb)
[![Build Status](https://travis-ci.org/bocharsky-bw/Arrayzy.svg?branch=master)](https://travis-ci.org/bocharsky-bw/Arrayzy)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bocharsky-bw/Arrayzy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bocharsky-bw/Arrayzy/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/bocharsky-bw/Arrayzy/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/bocharsky-bw/Arrayzy/?branch=master)

There are two avaliable classes with a different behaviour:

* [Arrayzy\MutableArray](#mutablearray)
* [Arrayzy\ImmutableArray](#immutablearray)

## MutableArray

Each functional method operate on the same array and return the same instance
(DO NOT create a new instance) except only few methods starts with `create` prefix.
This way a bit improve performance and provide more convenience usage in OOP way.

> **NOTE:** Check the [CreateClone](#createclone) section if you want to operate on new instance NOT on same instance.

## ImmutableArray

Each functional method operate on the same array but not modified it.
Instead of this it return a new object (create a new instance)
This way a bit disimprove performance but give you the behaviour
seems like most of built-in PHP functions that returns a new array (DO NOT modified input one).

> **NOTE:** If you don't need the first instance you operates on, you can override it manually:

``` php
$a = ImmutableArray::create(['a', 'b', 'c']);
$a = $a->shuffle(); // override instance you operates on, because $a !== $a->shuffle()
```

# Contents

* [Installation](#installation)
* [Creation](#creation)
* [Usage](#usage)
    * [Chaining](#chaining)
* [Public method list](#public-method-list)
    * [chunk](#chunk)
    * [clear](#clear)
    * [combineWith](#combinewith)
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
    * [diffWith](#diffwith)
    * [each](#each)
    * [export](#export)
    * [filter](#filter)
    * [first](#first)
    * [flip](#flip)
    * [getIterator](#getiterator)
    * [getKeys](#getkeys)
    * [getRandom](#getrandom)
    * [getRandomKey](#getrandomkey)
    * [getRandomKeys](#getrandomkeys)
    * [getRandomValues](#getrandomvalues)
    * [getValues](#getvalues)
    * [indexOf](#indexof)
    * [isEmpty](#isempty)
    * [key](#key)
    * [last](#last)
    * [map](#map)
    * [mergeWith](#mergewith)
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
    * [replaceWith](#replacewith)
    * [reverse](#reverse)
    * [shift](#shift)
    * [shuffle](#shuffle)
    * [slice](#slice)
    * [sort](#sort)
    * [sortKeys](#sortkeys)
    * [toArray](#toarray)
    * [toJson](#tojson)
    * [toReadableString](#toreadablestring)
    * [toString](#tostring)
    * [unique](#unique)
    * [unshift](#unshift)
    * [walk](#walk)
* [Links](#links)

## Installation

The preferred way to install this package is to use [Composer][1]:

``` bash
$ composer require bocharsky-bw/arrayzy:dev-master
```

If you don't use `Composer` - register this package in your autoloader manually
or download library manually and require the necessary files directly in your scripts:

``` php
require_once __DIR__ . '/path/to/library/src/MutableArray.php';
```

Don't forget namespace. Use [namespace arbitrary alias][2] for simplicity if you want:

``` php
use Arrayzy\MutableArray as MuArr;   //
use Arrayzy\ImmutableArray as ImArr; // MuArr and ImArr is the arbitrary aliases
```

## Creation

Create a new empty object with the `new` statement using declared arbitrary namespace aliases above:

``` php
$muArr = new MuArr; // Create new instance of MutableArray by namespace alias
// or
$imArr = new ImArr; // Create new instance of ImmutableArray by namespace alias
```

or with default values, passed an array to the constructor:

``` php
$a = new MuArr([1, 2, 3]);
// or
$a = new ImArr([1, 2, 3]);
```

Also, a new object could be created with one of few public `static` methods
that starts with `create` prefix and provide additional useful functionality:

* [create](#create)
* [createFromJson](#createfromjson)
* [createFromObject](#createfromobject)
* [createFromString](#createfromstring)
* [createWithRange](#createwithrange)


## Usage

You can get access to the instance values like with simple PHP `array` behaviour:

``` php
$a = MutableArray::create(['a', 'b', 'c']);

$a[] = 'e';    // or use $a->offsetSet(null, 'e') method
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c', 3 => 'e']

$a[3] = 'd';   // or use $a->offsetSet(3, 'd') method
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c', 3 => 'd']

print $a[1]; // 'b'
// or use corresponding method
print $a->offsetGet(1); // 'b'
```

> **NOTE:** The usage are suitable for both `MutableArray` and `ImmutableArray`

### Chaining

Use chaining methods for fast usage:

``` php
$a = MutableArray::create(['a', 'b', 'c']);

$a
    ->offsetSet(null, 'e')
    ->offsetSet(3, 'd')
    ->offsetSet(null, 'e')
    ->shuffle()
    ->reindex() // or any other method that return the current instance
;

$a->toArray(); // [0 => 'c', 1 => 'a', 2 => 'e', 3 => 'd', 4 => 'b']
```

### Converting

Easily converting instance array elements to a simple PHP `array`, `string`,
`readable string` or `JSON` format:

* [toArray](#toarray)
* [toJson](#tojson)
* [toReadableString](#toreadablestring)
* [toString](#tostring)

### Debugging

* [debug](#debug)
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

### combineWith

``` php
$a = MutableArray::create([1, 2, 3]);
$a->combineWith(['a', 'b', 'c']);
$a->toArray(); // [1 => 'a', 2 => 'b', 3 => 'c']
```

### contains

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->contains('c'); // true
```

### containsKey

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->containsKey(2); // true
```

### count

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->count(); // 3
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

Creates an instance array from a valid `JSON` string:

``` php
$a = MutableArray::createFromJson('{"a": 1, "b": 2, "c": 3}');
$a->toArray(); // ['a' => 1, 'b' => 2, 'c' => 3]
```

### createFromObject

Creates an instance array from any `object` that implemented `\ArrayAccess` interface:

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$b = MutableArray::createFromObject($a); // where $a could be any object that implemented \ArrayAccess interface
$b->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### createFromString

Creates an instance array from a simple PHP `string` with specified separator:

``` php
$a = MutableArray::createFromString('a;b;c', ';');
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### createWithRange

Creates an instance array with specified range:

``` php
$a = MutableArray::createWithRange(2, 6, 2);
$a->toArray(); // [0 => 2, 1 => 4, 2 => 6]
```

### current

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->current(); // 'a'
```

### customSort

``` php
$a = MutableArray::create(['b', 'a', 'c']);
$a->customSort(function($a, $b) {
    if ($a === $b) {
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
    if ($a === $b) {
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

### diffWith

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->diffWith(['c', 'd']);
$a->toArray(); // [0 => 'a', 1 => 'b']
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
    return 'z' !== $value; // exclude 'z' value from array 
});
$a->toArray(); // [0 => 'a', 2 => 'b']
```

### first

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->first(); // 'a'
```

### flip

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->flip();
$a->toArray(); // ['a' => 0, 'b' => 1, 'c' => 2]
```

### getIterator

Creates an external Iterator. Check the [iteratorAggregate][6] documentation for more information.

### getKeys

``` php
$a = MutableArray::create(['a' => 1, 'b' => 2, 'c' => 3]);
$a->getKeys(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### getRandom

``` php
$a = MutableArray::create(['a', 'b', 'c', 'd']);
$a->getRandom(); // 'c'
```

### getRandomKey

``` php
$a = MutableArray::create(['a', 'b', 'c', 'd']);
$a->getRandomKey(); // 2
```

### getRandomKeys

``` php
$a = MutableArray::create(['a', 'b', 'c', 'd']);
$a->getRandomKeys(2); // [0, 2]
```

### getRandomValues

``` php
$a = MutableArray::create(['a', 'b', 'c', 'd']);
$a->getRandomValues(2); // ['b', 'd']
```

### getValues

``` php
$a = MutableArray::create([1 => 'a', 2 => 'b', 3 => 'c']);
$a->getValues(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### indexOf

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->indexOf('b'); // 1 
```

### isEmpty

``` php
$a = MutableArray::create([]);
$a->isEmpty(); // true
```

### key

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->current(); // 'a'
$a->key();     // 0
$a->next();    // 'b'
$a->key();     // 1
```

### last

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->last(); // 'c'
```

### map

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->map(function($value) {
    return $value . $value;
});
$a->toArray(); // [0 => 'aa', 1 => 'bb', 2 => 'cc']
```

### mergeWith

``` php
// indexed array behavior
$a = MutableArray::create(['a', 'b', 'c']); // create indexed array
$a->mergeWith(['c', 'd']); // [0 => 'a', 1 => 'b', 2 => 'c', 3 => 'c', 4 => 'd']

// assoc array behavior
$b = MutableArray::create(['a' => 1, 'b' => 2, 'c' => 99]); // create assoc array
$b->mergeWith(['c' => 3, 'd' => 4]); // ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
```

### next

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->next(); // 'b'
$a->next(); // 'c'
```

### offsetExists

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->offsetExists(2); // true (or use isset($a[2]))
$a->offsetExists(3); // false (or use isset($a[3]))
```

### offsetGet

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->offsetGet(1); // 'b' (or use $a[1])
```

### offsetSet

``` php
$a = MutableArray::create(['a', 'b', 'd']);
// add new value
$a->offsetSet(null, 'd'); // or use $a[] = 'd';
$a->toArray();            // [0 => 'a', 1 => 'b', 2 => 'd', 3=> 'd']
// replace existing value by key
$a->offsetSet(2, 'c');    // or use $a[2] = 'c';
$a->toArray();            // [0 => 'a', 1 => 'b', 2 => 'c', 3=> 'd']
```

### offsetUnset

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->offsetUnset(1); // or use unset($a[1]);
$a->toArray();      // [0 => 'a', 2 => 'c']
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
$a->pop();     // 'c'
$a->toArray(); // [0 => 'a', 1 => 'b']
```

### previous

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->next();     // 'b'
$a->next();     // 'c'
$a->previous(); // 'b'
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
$a->reduce(function($result, $item) {
    return $result . $item;
}); // 'abc'
```

### reindex

``` php
$a = MutableArray::create([2 => 'a', 1 => 'b', 3 => 'c']);
$a->reindex();
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### replaceWith

``` php
$a = MutableArray::create(['a', 'd', 'e']);
$a->replaceWith([1 => 'b', 2 => 'c']);
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

Converts instance array to a simple PHP `array`:

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### toJson

Converts instance array to a `JSON` string:

``` php
$a = MutableArray::create(['a' => 1, 'b' => 2, 'c' => 3]);
$a->toJson(); // { "a": 1, "b": 2, "c":3 }
```

### toReadableString

Converts instance array to a readable PHP `string`:

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->toReadableString(', ', ' and '); // 'a, b, and c'
```

### toString

Converts instance array to a simple PHP `string`:

``` php
$a = MutableArray::create(['a', 'b', 'c']);
$a->toString('-'); // 'a-b-c'
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

Feel free to create an [Issue][3] or [Pull Request][4] if you find a bug 
or just want to propose improvement suggestion.

Look at the [Stringy][5] if you are looking for a PHP **string** manipulation library in OOP way.

[Move UP](#arrayzy)


[1]: https://getcomposer.org/
[2]: http://php.net/manual/en/language.namespaces.importing.php
[3]: https://github.com/bocharsky-bw/Arrayzy/issues
[4]: https://github.com/bocharsky-bw/Arrayzy/pulls
[5]: https://github.com/danielstjules/Stringy
[6]: http://php.net/manual/en/class.iteratoraggregate.php
