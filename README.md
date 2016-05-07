# Arrayzy

The wrapper for all PHP built-in array functions and easy, object-oriented array
manipulation library. In short: Arrays on steroids.

[![Travis Status](https://img.shields.io/travis/bocharsky-bw/Arrayzy/master.svg?style=flat-square)](https://travis-ci.org/bocharsky-bw/Arrayzy)
[![HHVM Status](https://img.shields.io/hhvm/bocharsky-bw/arrayzy/master.svg?style=flat-square)](http://hhvm.h4cc.de/package/bocharsky-bw/arrayzy)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/bocharsky-bw/Arrayzy.svg?style=flat-square)](https://scrutinizer-ci.com/g/bocharsky-bw/Arrayzy/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/bocharsky-bw/Arrayzy.svg?style=flat-square)](https://scrutinizer-ci.com/g/bocharsky-bw/Arrayzy/?branch=master)
[![Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](https://github.com/bocharsky-bw/Arrayzy/blob/master/LICENSE)
[![Latest Version](https://img.shields.io/packagist/v/bocharsky-bw/arrayzy.svg?style=flat-square)](https://packagist.org/packages/bocharsky-bw/arrayzy)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e0235f5d-a89b-4add-b3c6-45813d2bf9eb/big.png)](https://insight.sensiolabs.com/projects/e0235f5d-a89b-4add-b3c6-45813d2bf9eb)

## ArrayImitator

This is the *main* class of this library. Each method, which associated with
the corresponding native PHP function, keep its behavior. In other words:
methods could creates a new array (leaving the original array unchanged),
operates on the same array (returns the array itself and **DOES NOT** create
a new instance) or return some result.

> **NOTE:** If method creates a new array but you don't need the first array
  you operate on, you can override it manually:

``` php
use Arrayzy\ArrayImitator as A;

$a = A::create(['a', 'b', 'c']);
$a = $a->reverse(); // override instance you operates on, because $a !== $a->reverse()
```

> **NOTE:** If method operates on the same array but you need to keep the first
  array you operate on as unchanged, you can clone it manually first:

``` php
use Arrayzy\ArrayImitator as A;

$a = A::create(['a', 'b', 'c']);
$b = clone $a;
$b->shuffle(); // keeps $a unchanged, because $a !== $b
```

# Contents

* [Requirements](#requirements)
* [Installation](#installation)
* [Creation](#creation)
* [Usage](#usage)
    * [Chaining](#chaining)
* [Public method list](#public-method-list)
    * [add](#add)
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
    * [each](#each)
    * [end](#end)
    * [except](#except)
    * [exists](#exists)
    * [export](#export)
    * [filter](#filter)
    * [find](#find)
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
    * [intersect](#intersect)
    * [intersectAssoc](#intersectAssoc)
    * [intersectKey](#intersectKey)
    * [isAssoc](#isassoc)
    * [isEmpty](#isempty)
    * [isNumeric](#isnumeric)
    * [key](#key)
    * [last](#last)
    * [map](#map)
    * [merge](#merge)
    * [next](#next)
    * [offsetExists](#offsetexists)
    * [offsetGet](#offsetget)
    * [offsetSet](#offsetset)
    * [offsetUnset](#offsetunset)
    * [only](#only)
    * [pad](#pad)
    * [pop](#pop)
    * [previous](#previous)
    * [push](#push)
    * [reduce](#reduce)
    * [reindex](#reindex)
    * [replace](#replace)
    * [reset](#reset)
    * [reverse](#reverse)
    * [search](#search)
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
* [Contribution](#contribution)
* [Links](#links)

## Requirements

* PHP `5.4` or higher
* PHP `JSON` extension

## Installation

The preferred way to install this package is to use [Composer][1]:

``` bash
$ composer require bocharsky-bw/arrayzy
```

If you don't use `Composer` - register this package in your autoloader manually
or download this library and `require` the necessary files directly in your scripts:

``` php
require_once __DIR__ . '/path/to/library/src/ArrayImitator.php';
```

## Creation

Create a new empty array with the `new` statement.

``` php
use Arrayzy\ArrayImitator;

$a = new ArrayImitator; // Creates a new instance with the "use" statement
// or
$a = new \Arrayzy\ArrayImitator; // Creates a new array by fully qualified namespace
```

> **NOTE:** Don't forget about namespaces. You can use [namespace aliases][2]
  for simplicity if you want:

```php
use Arrayzy\ArrayImitator as A;

$a = new A; // Creates a new instance using namespace alias
```

Create a new array with default values, passed it to the constructor as an array:

``` php
$a = new A([1, 2, 3]);
// or
$a = new A([1 => 'a', 2 => 'b', 3 => 'c']);
```

Also, new objects can be created with one of the public static methods
prefixed with 'create':

* [create](#create)
* [createFromJson](#createfromjson)
* [createFromObject](#createfromobject)
* [createFromString](#createfromstring)
* [createWithRange](#createwithrange)

## Usage

You can get access to the values like with the familiar PHP array syntax:

``` php
use Arrayzy\ArrayImitator as A;

$a = A::create(['a', 'b', 'c']);

$a[] = 'e';    // or use $a->offsetSet(null, 'e') method
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c', 3 => 'e']

$a[3] = 'd';   // or use $a->offsetSet(3, 'd') method
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c', 3 => 'd']

print $a[1]; // 'b'
// or use the corresponding method
print $a->offsetGet(1); // 'b'
```

**NOTE:** *The following methods and principles apply to the `ArrayImitator` class.
In the examples provided below the `ArrayImitator` aliased with `A`.*

### Chaining

Methods may be chained for ease of use:

``` php
$a = A::create(['a', 'b', 'c']);

$a
    ->offsetSet(null, 'e')
    ->offsetSet(3, 'd')
    ->offsetSet(null, 'e')
    ->shuffle() // or any other method that returns $this
;

$a->toArray(); // [0 => 'c', 1 => 'a', 2 => 'e', 3 => 'd', 4 => 'b']
```

### Converting

Easily convert instance array elements to a simple PHP `array`, `string`,
readable `string` or JSON format:

* [toArray](#toarray)
* [toJson](#tojson)
* [toReadableString](#toreadablestring)
* [toString](#tostring)

### Debugging

* [debug](#debug)
* [export](#export)

## Public method list

### add

> Associated with `$a[] = 'new item'`.

``` php
$a = A::create(['a', 'b', 'c']);
$a->add('d');
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c', 3 => 'd']
```

### chunk

> Associated with [array_chunk()](https://secure.php.net/manual/en/function.array-chunk.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->chunk(2);
$a->toArray(); // [0 => [0 => 'a', 1 => 'b'], 1 => [0 => 'c']]
```

### clear

> Associated with `$a = []`.

``` php
$a = A::create(['a', 'b', 'c']);
$a->clear();
$a->toArray(); // []
```

### combine

> Associated with [array_combine()](https://secure.php.net/manual/en/function.array-combine.php).

``` php
$a = A::create([1, 2, 3]);
$a->combine(['a', 'b', 'c']);
$a->toArray(); // [1 => 'a', 2 => 'b', 3 => 'c']
```

### contains

> Associated with [in_array()](https://secure.php.net/manual/en/function.in-array.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->contains('c'); // true
```

### containsKey

> Associated with [array_key_exists()](https://secure.php.net/manual/en/function.array-key-exists.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->containsKey(2); // true
```

### count

> Associated with [count()](https://secure.php.net/manual/en/function.count.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->count(); // 3
```

### create

``` php
$a = A::create(['a', 'b', 'c']);
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### createClone

Creates a shallow copy of the array.

Keep in mind, that in PHP variables contain only references to the object, **NOT** the object itself:

``` php
$a = A::create(['a', 'b', 'c']);
$b = $a; // $a and $b are different variables referencing the same object ($a === $b)
```

So if you **DO NOT** want to modify the current array, you need to clone it manually first:

``` php
$a = A::create(['a', 'b', 'c']);
$b = clone $a; // $a and $b are different instances ($a !== $b)
// or do it with built-in method
$b = $a->createClone(); // $a !== $b
```

### createFromJson

> Associated with [json_decode()](https://secure.php.net/manual/en/function.json-decode.php).

Creates an array by parsing a JSON string:

``` php
$a = A::createFromJson('{"a": 1, "b": 2, "c": 3}');
$a->toArray(); // ['a' => 1, 'b' => 2, 'c' => 3]
```

### createFromObject

Creates an instance array from any `object` that implemented `\ArrayAccess` interface:

``` php
$a = A::create(['a', 'b', 'c']);
$b = A::createFromObject($a); // where $a could be any object that implemented \ArrayAccess interface
$b->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### createFromString

> Associated with [explode()](https://secure.php.net/manual/en/function.explode.php).

Creates an array from a simple PHP `string` with specified separator:

``` php
$a = A::createFromString('a;b;c', ';');
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### createWithRange

> Associated with [range()](https://secure.php.net/manual/en/function.range.php).

Creates an array of a specified range:

``` php
$a = A::createWithRange(2, 6, 2);
$a->toArray(); // [0 => 2, 1 => 4, 2 => 6]
```

### current

> Associated with [current()](https://secure.php.net/manual/en/function.current.php).

Position of the iterator.

``` php
$a = A::create(['a', 'b', 'c']);
$a->current(); // 'a'
```

### customSort

> Associated with [usort()](https://secure.php.net/manual/en/function.usort.php).

``` php
$a = A::create(['b', 'a', 'c']);
$a->customSort(function($a, $b) {
    if ($a === $b) {
        return 0;
    }

    return ($a < $b) ? -1 : 1;
});
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### customSortKeys

> Associated with [uksort()](https://secure.php.net/manual/en/function.uksort.php).

``` php
$a = A::create([1 => 'b', 0 => 'a', 2 => 'c']);
$a->customSortKeys(function($a, $b) {
    if ($a === $b) {
        return 0;
    }

    return ($a < $b) ? -1 : 1;
});
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### debug

> Associated with [print_r()](https://secure.php.net/manual/en/function.print-r.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->debug(); // Array ( [0] => a [1] => b [2] => c )
```

### diff

> Associated with [array_diff()](https://secure.php.net/manual/en/function.array-diff.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->diff(['c', 'd']);
$a->toArray(); // [0 => 'a', 1 => 'b']
```

### each

> Associated with [each()](https://secure.php.net/manual/en/function.each.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->each(); // [0 => 0, 'key' => 0, 1 => 'a', 'value' => 'a']
```

### end

> Associated with [end()](https://secure.php.net/manual/en/function.end.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->end(); // 'c'
```

### except

> Based on [array_diff_key()](https://secure.php.net/manual/en/function.array-diff-key.php).

Chunk of an array without given keys.

``` php
$a = A::create(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5]);
$a->except(['b', 'e']);
$a->toArray(); // ['a' => 1, 'c' => 3, 'd' => 4]
```


### exists

A custom contains method where you can supply your own custom logic in any callable function.

``` php
$a = A::create(['a', 'b', 'c']);

$a->exists(function($key, $value) {
   return 1 === $key and 'b' === $value;
}); // true
```

### export

> Associated with [var_export()](https://secure.php.net/manual/en/function.var-export.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->export(); // array ( 0 => 'a', 1 => 'b', 2 => 'c', )
```

### filter

> Associated with [array_filter()](https://secure.php.net/manual/en/function.array-filter.php).

``` php
$a = A::create(['a', 'z', 'b', 'z']);
$a->filter(function($value) {
    return 'z' !== $value; // exclude 'z' value from array
});
$a->toArray(); // [0 => 'a', 2 => 'b']
```

### find

A custom find method where you can supply your own custom logic in any callable function.

``` php
$a = A::create(['a', 'b', 'c']);
$a->find(function($value, $key) {
    return 'b' == $value && 0 < $key;
}); // 'b'
```

### first

> Alias of [reset](#reset).

``` php
$a = A::create(['a', 'b', 'c']);
$a->first(); // 'a'
```

### flip

> Associated with [array_flip()](https://secure.php.net/manual/en/function.array-flip.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->flip();
$a->toArray(); // ['a' => 0, 'b' => 1, 'c' => 2]
```

### getIterator

Creates an external Iterator. Check the [iteratorAggregate][6] documentation for more information.

### getKeys

> Associated with [array_keys()](https://secure.php.net/manual/en/function.array-keys.php).

``` php
$a = A::create(['a' => 1, 'b' => 2, 'c' => 3]);
$a->getKeys(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### getRandom

> Associated with [array_rand()](https://secure.php.net/manual/en/function.array-rand.php).

``` php
$a = A::create(['a', 'b', 'c', 'd']);
$a->getRandom(); // 'c'
```

### getRandomKey

> Associated with [array_rand()](https://secure.php.net/manual/en/function.array-rand.php).

``` php
$a = A::create(['a', 'b', 'c', 'd']);
$a->getRandomKey(); // 2
```

### getRandomKeys

> Associated with [array_rand()](https://secure.php.net/manual/en/function.array-rand.php).

``` php
$a = A::create(['a', 'b', 'c', 'd']);
$a->getRandomKeys(2); // [0, 2]
```

### getRandomValues

> Associated with [array_rand()](https://secure.php.net/manual/en/function.array-rand.php).

``` php
$a = A::create(['a', 'b', 'c', 'd']);
$a->getRandomValues(2); // ['b', 'd']
```

### getValues

> Associated with [array_values()](https://secure.php.net/manual/en/function.array-values.php).

``` php
$a = A::create([1 => 'a', 2 => 'b', 3 => 'c']);
$a->getValues(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### indexOf

> Alias of [search](#search).

``` php
$a = A::create(['a', 'b', 'c']);
$a->indexOf('b'); // 1
```
### intersect

> Associated with [array_intersect()](https://secure.php.net/manual/en/function.array-intersect.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->intersect(['b', 'c']);
$a->toArray(); // [1 => 'b', 2 => 'c']
```
### intersectAssoc

> Associated with [array_intersect_assoc()](https://secure.php.net/manual/en/function.array-intersect-assoc.php).

``` php
$a = A::create(['one' => 'a', 'two' => 'b', 'three' => 'c']);
$a->intersectAssoc(['two' => 'b', 'four' => 'c']);
$a->toArray(); // ['two' => 'b']
```

### intersectKey

> Associated with [array_intersect_key()](https://secure.php.net/manual/en/function.array-intersect-key.php).

``` php
$a = A::create(['one' => 'a', 'two' => 'b', 'three' => 'c']);
$a->intersectKey(['two' => 'd', 'three' => 'e']);
$a->toArray(); // ['two' => 'b', 'three' => 'c']
```

### isAssoc

Check whether all array keys are *associative*.

``` php
$a = A::create(['key' => 'value']);
$a->isAssoc(); // true
```

### isEmpty

Check whether array is empty.

``` php
$a = A::create([]);
$a->isEmpty(); // true
```

### isNumeric

Check whether all array keys are *numeric*.

``` php
$a = A::create(['a', 'b', 'c']);
$a->isNumeric(); // true
```

### key

> Associated with [key()](https://secure.php.net/manual/en/function.key.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->current(); // 'a'
$a->key();     // 0
$a->next();    // 'b'
$a->key();     // 1
```

### last

> Alias of [end](#end).

``` php
$a = A::create(['a', 'b', 'c']);
$a->last(); // 'c'
```

### map

> Associated with [array_map()](https://secure.php.net/manual/en/function.array-map.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->map(function($value) {
    return $value . $value;
});
$a->toArray(); // [0 => 'aa', 1 => 'bb', 2 => 'cc']
```

### merge

> Associated with [array_merge()](https://secure.php.net/manual/en/function.array-merge.php) /
  [array_merge_recursive()](https://secure.php.net/manual/en/function.array-merge-recursive.php).

``` php
// indexed array behavior
$a = A::create(['a', 'b', 'c']); // create indexed array
$a->merge(['c', 'd']); // [0 => 'a', 1 => 'b', 2 => 'c', 3 => 'c', 4 => 'd']

// assoc array behavior
$b = A::create(['a' => 1, 'b' => 2, 'c' => 99]); // create assoc array
$b->merge(['c' => 3, 'd' => 4]); // ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
```

### next

> Associated with [next()](https://secure.php.net/manual/en/function.next.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->next(); // 'b'
$a->next(); // 'c'
```

### offsetExists

> Implemented for [ArrayAccess](https://secure.php.net/manual/en/arrayaccess.offsetexists.php) interface.

``` php
$a = A::create(['a', 'b', 'c']);
$a->offsetExists(2); // true (or use isset($a[2]))
$a->offsetExists(3); // false (or use isset($a[3]))
```

### offsetGet

> Implemented for [ArrayAccess](https://secure.php.net/manual/en/arrayaccess.offsetget.php) interface.

``` php
$a = A::create(['a', 'b', 'c']);
$a->offsetGet(1); // 'b' (or use $a[1])
```

### offsetSet

> Implemented for [ArrayAccess](https://secure.php.net/manual/en/arrayaccess.offsetset.php) interface.

``` php
$a = A::create(['a', 'b', 'd']);
// add a new value
$a->offsetSet(null, 'd'); // or use $a[] = 'd';
$a->toArray();            // [0 => 'a', 1 => 'b', 2 => 'd', 3=> 'd']
// replace an existing value by key
$a->offsetSet(2, 'c');    // or use $a[2] = 'c';
$a->toArray();            // [0 => 'a', 1 => 'b', 2 => 'c', 3=> 'd']
```

### offsetUnset

> Implemented for [ArrayAccess](https://secure.php.net/manual/en/arrayaccess.offsetunset.php) interface.

``` php
$a = A::create(['a', 'b', 'c']);
$a->offsetUnset(1); // or use unset($a[1]);
$a->toArray();      // [0 => 'a', 2 => 'c']
```

### only

> Based on [array_intersect_key()](https://secure.php.net/manual/en/function.array-intersect-key.php).

Chunk of an array with only given keys.

``` php
$a = A::create(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5]);
$a->only(['b', 'e']);
$a->toArray(); // ['b' => 2, 'e' => 5]
```

### pad

> Associated with [array_pad()](https://secure.php.net/manual/en/function.array-pad.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->pad(5, 'z');
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c', 3 => 'z', 4 => 'z']
```

### pop

> Associated with [array_pop()](https://secure.php.net/manual/en/function.array-pop.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->pop();     // 'c'
$a->toArray(); // [0 => 'a', 1 => 'b']
```

### previous

> Associated with [prev()](https://secure.php.net/manual/en/function.prev.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->next();     // 'b'
$a->next();     // 'c'
$a->previous(); // 'b'
```

### push

> Associated with [array_push()](https://secure.php.net/manual/en/function.array-push.php).

``` php
$a = A::create(['a', 'b']);
$a->push('c', 'd');
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c', 3 => 'd']
```

> The `push()` method allows multiple arguments.

### reduce

> Associated with [array_reduce()](https://secure.php.net/manual/en/function.array-reduce.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->reduce(function($result, $item) {
    return $result . $item;
}); // 'abc'
```

### reindex

> Based on [array_values()](https://secure.php.net/manual/en/function.array-values.php).

``` php
$a = A::create([2 => 'a', 1 => 'b', 3 => 'c']);
$a->reindex();
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### replace

> Associated with [array_replace()](https://secure.php.net/manual/en/function.array-replace.php) /
  [array_replace_recursive()](https://secure.php.net/manual/en/function.array-replace-recursive.php).

``` php
$a = A::create(['a', 'd', 'e']);
$a->replace([1 => 'b', 2 => 'c']);
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### reset

> Associated with [reset()](https://secure.php.net/manual/en/function.reset.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->reset(); // 'a'
```

### reverse

> Associated with [array_reverse()](https://secure.php.net/manual/en/function.array-reverse.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->reverse();
$a->toArray(); // [0 => 'c', 1 => 'b', 2 => 'a']
```

### search

> Associated with [array_search()](https://secure.php.net/manual/en/function.array-search.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->search('b'); // 1
```

### shift

> Associated with [array_shift()](https://secure.php.net/manual/en/function.array-shift.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->shift();
$a->toArray(); // [0 => 'b', 1 => 'c']
```

### shuffle

> Associated with [shuffle()](https://secure.php.net/manual/en/function.shuffle.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->shuffle();
$a->toArray(); // [0 => 'c', 1 => 'a', 2 => 'b']
```

### slice

> Associated with [array_slice()](https://secure.php.net/manual/en/function.array-slice.php).

``` php
$a = A::create(['a', 'b', 'c', 'd']);
$a->slice(1, 2);
$a->toArray(); // [0 => 'b', 1 => 'c']
```

### sort

> Associated with [arsort()](https://secure.php.net/manual/en/function.arsort.php) /
  [sort()](https://secure.php.net/manual/en/function.sort.php) /
  [asort()](https://secure.php.net/manual/en/function.asort.php) /
  [rsort()](https://secure.php.net/manual/en/function.rsort.php).

``` php
$a = A::create(['b', 'a', 'd', 'c']);
$a->sort(SORT_DESC);
$a->toArray(); // [0 => 'd', 1 => 'c', 2 => 'b', 3 => 'a']
```

### sortKeys

> Associated with [ksort()](https://secure.php.net/manual/en/function.ksort.php) /
  [krsort()](https://secure.php.net/manual/en/function.krsort.php).

``` php
$a = A::create([3 => 'a', 1 => 'b', 2 => 'c', 0 => 'd']);
$a->sortKeys(SORT_ASC);
$a->toArray(); // [0 => 'd', 1 => 'b', 2 => 'c', 3 => 'a']
```

### toArray

Convert the array to a simple PHP `array` type:

``` php
$a = A::create(['a', 'b', 'c']);
$a->toArray(); // [0 => 'a', 1 => 'b', 2 => 'c']
```

### toJson

> Associated with [json_encode()](https://secure.php.net/manual/en/function.json-encode.php).

Creates a JSON string from the array:

``` php
$a = A::create(['a' => 1, 'b' => 2, 'c' => 3]);
$a->toJson(); // { "a": 1, "b": 2, "c": 3 }
```

### toReadableString

> Based on [implode()](https://secure.php.net/manual/en/function.implode.php).

Converts instance array to a readable PHP `string`:

``` php
$a = A::create(['a', 'b', 'c']);
$a->toReadableString(', ', ' and '); // 'a, b and c'
```

### toString

> Associated with [implode()](https://secure.php.net/manual/en/function.implode.php).

Converts instance array to a simple PHP `string`:

``` php
$a = A::create(['a', 'b', 'c']);
$a->toString(', '); // 'a, b, c'
```

### unique

> Associated with [array_unique()](https://secure.php.net/manual/en/function.array-unique.php).

``` php
$a = A::create(['a', 'b', 'b', 'c']);
$a->unique();
$a->toArray(); // [0 => 'a', 1 => 'b', 3 => 'c']
```

### unshift

> Associated with [array_unshift()](https://secure.php.net/manual/en/function.array-unshift.php).

``` php
$a = A::create(['a', 'b']);
$a->unshift('y', 'z');
$a->toArray(); // [0 => 'y', 1 => 'z', 2 => 'a', 3 => 'b']
```

> Method `unshift()` allow multiple arguments.

### walk

> Associated with [array_walk()](https://secure.php.net/manual/en/function.array-walk.php) /
  [array_walk_recursive()](https://secure.php.net/manual/en/function.array-walk-recursive.php).

``` php
$a = A::create(['a', 'b', 'c']);
$a->walk(function(&$value, $key) {
    $key++; // the $key variable passed by value, (original value will not modified)
    $value = $value . $key; // the $value variable passed by reference (modifies original value)
});
$a->toArray(); // [0 => 'a1', 1 => 'b2', 2 => 'c3']
```

## Contribution

Feel free to submit an [Issue][3] or create a [Pull Request][4] if you find a bug
or just want to propose an improvement suggestion.

In order to propose a new feature the best way is to submit an [Issue][3] and discuss it first.

## Links

**Arrayzy** was inspired by Doctrine [ArrayCollection][7] class and [Stringy][5] library.

Look at the [Stringy][5] if you are looking for a PHP *string* manipulation library in an OOP way.

[Move UP](#arrayzy)


[1]: https://getcomposer.org/
[2]: https://secure.php.net/manual/en/language.namespaces.importing.php
[3]: https://github.com/bocharsky-bw/Arrayzy/issues
[4]: https://github.com/bocharsky-bw/Arrayzy/pulls
[5]: https://github.com/danielstjules/Stringy
[6]: https://secure.php.net/manual/en/class.iteratoraggregate.php
[7]: https://github.com/doctrine/collections/blob/master/lib/Doctrine/Common/Collections/ArrayCollection.php
