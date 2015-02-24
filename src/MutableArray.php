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
    const DEFAULT_SEPARATOR = '';

    /**
     * @var array
     */
    private $elements = [];

    /**
     * Construct new instance
     *
     * @param array $elements
     */
    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    /**
     * Converting instance to string with default separator
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Create a new instance
     *
     * @param array $elements
     *
     * @return static Returns created instance
     */
    public static function create(array $elements = [])
    {
        return new static($elements);
    }

    /**
     * Create a new instance containing a range of elements
     *
     * @param mixed $low First value of the sequence
     * @param mixed $high The sequence is ended upon reaching the end value
     * @param int $step Used as the increment between elements in the sequence
     *
     * @return static Returns created instance
     */
    public static function createWithRange($low, $high, $step = 1)
    {
        return new static(range($low, $high, $step));
    }

    /**
     * Create a new instance from the implemented ArrayAccess instance
     *
     * @param ArrayAccess $elements Object that implements the ArrayAccess
     *
     * @return static Returns created instance
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
     * Decode a JSON string to new instance
     *
     * @param string $json The json string being decoded
     * @param int $options Bitmask of JSON decode options
     * @param int $depth Specified recursion depth
     *
     * @return static Returns created instance
     */
    public static function createFromJson($json, $options = 0, $depth = 512)
    {
        return new static(json_decode($json, true, $depth, $options));
    }

    /**
     * Explode a string to new instance by specified separator
     *
     * @param string $string Converted string
     * @param string $separator Element's separator
     *
     * @return static Returns created instance
     */
    public static function createFromString($string, $separator)
    {
        return new static(explode($separator, $string));
    }

    /**
     * Clone current instance to new instance
     *
     * @return $this Returns cloned instance
     */
    public function createClone()
    {
        return clone $this;
    }

    /**
     * Convert instance to PHP array
     *
     * @return array The PHP array
     */
    public function toArray()
    {
        return $this->elements;
    }

    /**
     * Encode instance to JSON string
     *
     * @param int $options Bitmask
     * @param int $depth Set the maximum depth. Must be greater than zero
     *
     * @return string The JSON representation of instance
     */
    public function toJson($options = 0, $depth = 512)
    {
        if (version_compare(PHP_VERSION, '5.5.0', '>=')) {
            return json_encode($this->elements, $options, $depth);
        }

        return json_encode($this->elements, $options);
    }

    /**
     * Implode instance to string with specified separator
     *
     * @param string $separator Element's separator
     *
     * @return string Converted instance string
     */
    public function toString($separator = self::DEFAULT_SEPARATOR)
    {
        return implode($separator, $this->elements);
    }

    /**
     * Exchanges all instance keys with their associated values
     *
     * @return $this The instance with flipped elements
     */
    public function flip()
    {
        $this->elements = array_flip($this->elements);

        return $this;
    }

    /**
     * PLace instance elements in reverse order
     *
     * @param bool $preserveKeys Whether instance element keys are preserved or no
     *
     * @return $this The instance with reversed elements
     */
    public function reverse($preserveKeys = false)
    {
        $this->elements = array_reverse($this->elements, $preserveKeys);

        return $this;
    }

    /**
     * Extract a slice of instance elements
     *
     * @param int $offset
     * @param int|null $length Length of instance sliced elements
     * @param bool $preserveKeys Whether instance element keys are preserved or no
     *
     * @return $this The instance with sliced elements
     */
    public function slice($offset, $length = null, $preserveKeys = false)
    {
        $this->elements = array_slice($this->elements, $offset, $length, $preserveKeys);

        return $this;
    }

    /**
     * Split instance elements into chunks
     *
     * @param int $size The size of each chunk
     * @param bool $preserveKeys Whether instance element keys are preserved or no
     *
     * @return $this The instance with splitted elements
     */
    public function chunk($size, $preserveKeys = false)
    {
        $this->elements = array_chunk($this->elements, $size, $preserveKeys);

        return $this;
    }

    /**
     * Removes duplicate values from instance elements
     *
     * @param int|null $sortFlags
     *
     * @return $this The instance with unique elements
     */
    public function unique($sortFlags = null)
    {
        $this->elements = array_unique($this->elements, $sortFlags);

        return $this;
    }

    /**
     * Merge instance elements with given array
     *
     * @param array $array The array merged with instance elements
     * @param bool $recursively Whether elements will be merged recursively or no
     *
     * @return $this The instance with merged elements
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
     * Replace instance elements with given array
     *
     * @param array $array The array replaced with instance elements
     * @param bool $recursively Whether elements will be replaced recursively or no
     *
     * @return $this The instance with replaced elements
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
     * Combine instance element keys with given array values
     *
     * @param array $array The array combined with instance elements
     *
     * @return $this The instance with combined elements
     */
    public function combine(array $array)
    {
        $this->elements = array_combine($this->elements, $array);

        return $this;
    }

    /**
     * Compute the difference of instance elements with given array
     *
     * @param array $array
     *
     * @return $this The instance containing all the entries from instance elements that are not present in given array
     */
    public function diff(array $array)
    {
        $this->elements = array_diff($this->elements, $array);

        return $this;
    }

    /**
     * Check if the given key or index exists in instance elements
     *
     * @param mixed $key
     *
     * @return bool Whether instance elements contains given key or no
     */
    public function containsKey($key)
    {
        return array_key_exists($key, $this->elements);
    }

    /**
     * Check if the given value exists in instance elements
     *
     * @param mixed $element
     *
     * @return bool Whether instance elements contains given value or no
     */
    public function contains($element)
    {
        return in_array($element, $this->elements, true);
    }

    /**
     * Search in instance elements for a given element
     *
     * @param mixed $element
     *
     * @return mixed The corresponding key or index
     */
    public function indexOf($element)
    {
        return array_search($element, $this->elements, true);
    }

    /**
     * Apply the given callback to the instance elements
     *
     * @param callable $callable
     *
     * @return $this The instance with filtered elements
     */
    public function map(Closure $callable)
    {
        $this->elements = array_map($callable, $this->elements);

        return $this;
    }

    /**
     * Filter instance elements with given callback
     *
     * @param callable $callable
     *
     * @return $this The instance with modified elements
     */
    public function filter(Closure $callable)
    {
        $this->elements = array_filter($this->elements, $callable);

        return $this;
    }

    /**
     * Apply the given callback to every instance element
     *
     * @param callable $callable
     * @param bool $recursively Whether elements will be walked recursively or no
     *
     * @return $this The instance with modified elements
     */
    public function walk(Closure $callable, $recursively = false)
    {
        if (true === $recursively) {
            array_walk_recursive($this->elements, $callable);
        } else {
            array_walk($this->elements, $callable);
        }

        return $this;
    }

    /**
     * Iteratively reduce instance elements to a single value using a callback function
     *
     * @param callable $callable
     * @param mixed|null $initial
     *
     * @return mixed The resulting value
     */
    public function reduce(Closure $callable, $initial = null)
    {
        return array_reduce($this->elements, $callable, $initial);
    }

    /**
     * Shift an value off the beginning of instance elements
     *
     * @return mixed The shift value
     */
    public function shift()
    {
        return array_shift($this->elements);
    }

    /**
     * Prepend a new value to the beginning of instance elements
     *
     * @param mixed $element The value for prepend
     *
     * @return $this The instance with prepended value to the beginning of instance elements
     */
    public function unshift($element)
    {
        array_unshift($this->elements, $element);

        return $this;
    }

    /**
     * Pop the value off the end of instance elements
     *
     * @return mixed The popped element
     */
    public function pop()
    {
        return array_pop($this->elements);
    }

    /**
     * Push value onto the end of instance elements
     *
     * @param mixed $element The value for push
     *
     * @return $this The instance with pushed value to the end of instance elements
     */
    public function push($element)
    {
        array_push($this->elements, $element);

        return $this;
    }

    /**
     * Pad instance elements to the specified length with a value
     *
     * @param int $size
     * @param mixed $value
     *
     * @return $this The instance with padded elements
     */
    public function pad($size, $value)
    {
        $this->elements = array_pad($this->elements, $size, $value);

        return $this;
    }

    /**
     * Return all the keys or a subset of the keys of instance elements
     *
     * @return array An array of all the instance elements keys
     */
    public function getKeys()
    {
        return array_keys($this->elements);
    }

    /**
     * Return all the values of instance elements
     *
     * @return mixed An array of all the instance elements values
     */
    public function getValues()
    {
        return array_values($this->elements);
    }

    /**
     * Pick one random element out of instance elements
     *
     * @return mixed Random value of of instance elements
     */
    public function getRandom()
    {
        if ($this->isEmpty()) {
            return null;
        }

        return $this->offsetGet(array_rand($this->elements, 1));
    }

    /**
     * Shuffle instance elements
     *
     * @return $this The instance with shuffled elements
     */
    public function shuffle()
    {
        shuffle($this->elements);

        return $this;
    }

    /**
     * Check whether instance elements are empty
     *
     * @return bool Whether instance elements are empty or no
     */
    public function isEmpty()
    {
        return !$this->elements;
    }

    /**
     * Clear instance elements
     *
     * @return $this The instance with clearing elements
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
     *
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
     *
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
     *
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
     *
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
     *
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
     *
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
     *
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
     *
     * @return array
     */
    public function each()
    {
        return each($this->elements);
    }

    /**
     * Whether a offset exists
     *
     * @param mixed $offset An offset to check for.
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @return boolean true on success or false on failure.
     */
    public function offsetExists($offset)
    {
        return isset($this->elements[$offset]);
    }

    /**
     * Offset to retrieve
     *
     * @param mixed $offset The offset to retrieve.
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     *
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
     * @param mixed $offset The offset to assign the value to.
     * @param mixed $value The value to set.
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     *
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
     * @param mixed $offset The offset to unset.
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     *
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
     *
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     */
    public function getIterator()
    {
        return new ArrayIterator($this->elements);
    }
}
