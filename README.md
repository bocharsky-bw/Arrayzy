# Arrayzy

A PHP array easy manipulation library in OOP way.

[![Build Status](https://travis-ci.org/bocharsky-bw/Arrayzy.svg?branch=master)](https://travis-ci.org/bocharsky-bw/Arrayzy)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e0235f5d-a89b-4add-b3c6-45813d2bf9eb/mini.png)](https://insight.sensiolabs.com/projects/e0235f5d-a89b-4add-b3c6-45813d2bf9eb)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bocharsky-bw/Arrayzy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bocharsky-bw/Arrayzy/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/bocharsky-bw/Arrayzy/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/bocharsky-bw/Arrayzy/?branch=master)

* [Installation](#installation)
* [Creation](#creation)
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

Don't forget about namespace. Use namespace arbitrary alias for simplicity:

``` php
use Arrayzy\MutableArray as MuArr;
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

## Public method list

Docs will be added soon...

Look at the [Stringy](https://github.com/danielstjules/Stringy) if you are looking for a PHP string manipulation library in OOP way.
