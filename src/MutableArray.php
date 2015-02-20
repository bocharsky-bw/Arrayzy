<?php

namespace Arrayzy;

use Countable;
use ArrayAccess;
use IteratorAggregate;
use Traversable;
use ArrayIterator;
use Closure;

/**
 * Class MutableArray
 */
class MutableArray implements Countable, ArrayAccess, IteratorAggregate
{
    /**
     * @const string
     */
    const SEPARATOR = '';

    /**
     * @var array
     */
    private $elements = [];

    /**
     * @param array $elements
     */
    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @param array $elements
     * @return $this
     */
    public static function create(array $elements = [])
    {
        return new static($elements);
    }

    /**
     * @param ArrayAccess $elements
     * @return $this
     */
    public static function createFromObject(ArrayAccess $elements)
    {
        $array = new static();

        foreach ($elements as $key => $value) {
            $array->offsetSet($key, $value);
        }

        return $array;
    }

    /**
     * @param string $json
     * @param int $options
     * @param int $depth
     * @return $this
     */
    public static function createFromJson($json, $options = 0, $depth = 512)
    {
        return new static(json_decode($json, true, $depth, $options));
    }

    /**
     * @param string $string
     * @param string $separator
     * @return $this
     */
    public static function createFromString($string, $separator = self::SEPARATOR)
    {
        return new static(explode($separator, $string));
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->elements;
    }

    /**
     * @param int $options
     * @param int $depth
     * @return string
     */
    public function toJson($options = 0, $depth = 512)
    {
        if (version_compare(PHP_VERSION, '5.5.0', '>=')) {
            return json_encode($this->elements, $options, $depth);
        }

        return json_encode($this->elements, $options);
    }

    /**
     * @param string $separator
     * @return string
     */
    public function toString($separator = self::SEPARATOR)
    {
        return implode($separator, $this->elements);
    }

    /**
     * @return $this
     */
    public function flip()
    {
        $this->elements = array_flip($this->elements);

        return $this;
    }

    /**
     * @param bool $preserveKeys
     * @return $this
     */
    public function reverse($preserveKeys = false)
    {
        $this->elements = array_reverse($this->elements, $preserveKeys);

        return $this;
    }

    /**
     * @param int $offset
     * @param int|null $length
     * @param bool $preserveKeys
     * @return $this
     */
    public function slice($offset, $length = null, $preserveKeys = false)
    {
        $this->elements = array_slice($this->elements, $offset, $length, $preserveKeys);

        return $this;
    }

    /**
     * @param int $size
     * @param bool $preserveKeys
     * @return $this
     */
    public function chunk($size, $preserveKeys = false)
    {
        $this->elements = array_chunk($this->elements, $size, $preserveKeys);

        return $this;
    }

    /**
     * Removes duplicate values from an array
     *
     * @param int|null $sortFlags
     * @return $this
     */
    public function unique($sortFlags = null)
    {
        $this->elements = array_unique($this->elements, $sortFlags);

        return $this;
    }

    /**
     * @param array $array
     * @param bool $recursively
     * @return $this
     */
    public function merge(array $array, $recursively = false)
    {
        if (true === $recursively) {
            $this->elements = array_merge_recursive($this->elements, $array);
        } else {
            $this->elements = array_merge($this->elements, $array);
        }

        return $this;
    }

    /**
     * @param array $array
     * @param bool $recursively
     * @return $this
     */
    public function replace(array $array, $recursively = false)
    {
        if (true === $recursively) {
            $this->elements = array_replace_recursive($this->elements, $array);
        } else {
            $this->elements = array_replace($this->elements, $array);
        }

        return $this;
    }

    /**
     * @param array $array
     * @return $this
     */
    public function combine(array $array)
    {
        $this->elements = array_combine($this->elements, $array);

        return $this;
    }

    /**
     * @param array $array
     * @return $this
     */
    public function diff(array $array)
    {
        $this->elements = array_diff($this->elements, $array);

        return $this;
    }

    /**
     * @param mixed $key
     * @return bool
     */
    public function containsKey($key)
    {
        return array_key_exists($key, $this->elements);
    }

    /**
     * @param mixed $element
     * @return bool
     */
    public function contains($element)
    {
        return in_array($element, $this->elements, true);
    }

    /**
     * @param mixed $element
     * @return mixed
     */
    public function indexOf($element)
    {
        return array_search($element, $this->elements, true);
    }

    /**
     * @param callable $callable
     * @return $this
     */
    public function map(Closure $callable)
    {
        $this->elements = array_map($callable, $this->elements);

        return $this;
    }

    /**
     * @param callable $callable
     * @return $this
     */
    public function filter(Closure $callable)
    {
        $this->elements = array_filter($this->elements, $callable);

        return $this;
    }

    /**
     * @param callable $callable
     * @param mixed|null $userData
     * @param bool $recursively
     * @return $this
     */
    public function walk(Closure $callable, $userData = null, $recursively = false)
    {
        if (true === $recursively) {
            array_walk_recursive($this->elements, $callable, $userData);
        } else {
            array_walk($this->elements, $callable, $userData);
        }

        return $this;
    }

    /**
     * @param callable $callable
     * @param mixed|null $initial
     * @return mixed
     */
    public function reduce(Closure $callable, $initial = null)
    {
        return array_reduce($this->elements, $callable, $initial);
    }

    /**
     * Shift an element off the beginning of array
     *
     * @return mixed
     */
    public function shift()
    {
        return array_shift($this->elements);
    }

    /**
     * Prepend one or more elements to the beginning of an array
     *
     * @param mixed $element The prepended variable
     * @return $this
     */
    public function unshift($element)
    {
        array_unshift($this->elements, $element);

        return $this;
    }

    /**
     * Pop the element off the end of array
     *
     * @return mixed
     */
    public function pop()
    {
        return array_pop($this->elements);
    }

    /**
     * Push one or more elements onto the end of array
     *
     * @param mixed $element The pushed value
     * @return $this
     */
    public function push($element)
    {
        array_push($this->elements, $element);

        return $this;
    }

    /**
     * @param int $size
     * @param mixed $value
     * @return $this
     */
    public function pad($size, $value)
    {
        $this->elements = array_pad($this->elements, $size, $value);

        return $this;
    }

    /**
     * Return all the keys of an array
     *
     * @return array
     */
    public function getKeys()
    {
        return array_keys($this->elements);
    }

    /**
     * Return all the values of an array
     *
     * @return array
     */
    public function getValues()
    {
        return array_values($this->elements);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return ! $this->elements;
    }

    /**
     * @return $this
     */
    public function clear()
    {
        $this->elements = [];

        return $this;
    }

    /**
     * Counts all elements in array
     *
     * @link http://php.net/manual/en/function.count.php
     * @return int
     */
    public function count()
    {
        return count($this->elements);
    }

    /**
     * Set the internal pointer of an array to its first element
     *
     * @link http://php.net/manual/en/function.reset.php
     * @return mixed
     */
    public function first()
    {
        return reset($this->elements);
    }

    /**
     * Set the internal pointer of an array to its last element
     *
     * @link http://php.net/manual/en/function.end.php
     * @return mixed
     */
    public function last()
    {
        return end($this->elements);
    }

    /**
     * Advance the internal array pointer of an array
     *
     * @link http://php.net/manual/en/function.next.php
     * @return mixed
     */
    public function next()
    {
        return next($this->elements);
    }

    /**
     * Rewind the internal array pointer
     *
     * @link http://php.net/manual/en/function.prev.php
     * @return mixed
     */
    public function previous()
    {
        return prev($this->elements);
    }

    /**
     * Fetch a key from an array
     *
     * @link http://php.net/manual/en/function.key.php
     * @return mixed
     */
    public function key()
    {
        return key($this->elements);
    }

    /**
     * Return the current element in an array
     *
     * @link http://php.net/manual/en/function.current.php
     * @return mixed
     */
    public function current()
    {
        return current($this->elements);
    }

    /**
     * Return the current key and value pair from an array and advance the array cursor
     *
     * @link http://php.net/manual/en/function.current.php
     * @return array
     */
    public function each()
    {
        return each($this->elements);
    }

    /**
     * Whether a offset exists
     *
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset An offset to check for.
     * @return boolean true on success or false on failure.
     */
    public function offsetExists($offset)
    {
        return isset($this->elements[$offset]);
    }

    /**
     * Offset to retrieve
     *
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset The offset to retrieve.
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return isset($this->elements[$offset])
            ? $this->elements[$offset]
            : null
        ;
    }

    /**
     * Offset to set
     *
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset The offset to assign the value to.
     * @param mixed $value The value to set.
     * @return $this
     */
    public function offsetSet($offset, $value)
    {
        if (isset($offset)) {
            $this->elements[$offset] = $value;
        } else {
            $this->elements[] = $value;
        }
    }

    /**
     * Offset to unset
     *
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset The offset to unset.
     * @return $this
     */
    public function offsetUnset($offset)
    {
        unset($this->elements[$offset]);

        return $this;
    }

    /**
     * Retrieve an external iterator
     *
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     */
    public function getIterator()
    {
        return new ArrayIterator($this->elements);
    }
}
