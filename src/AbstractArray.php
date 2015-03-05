<?php

namespace Arrayzy;

use Arrayzy\Traits\ConvertibleTrait;
use Arrayzy\Traits\CreatableTrait;
use Arrayzy\Traits\DebuggableTrait;
use Arrayzy\Traits\ModifiableTrait;
use Arrayzy\Traits\SortableTrait;
use Arrayzy\Traits\TraversableTrait;
use ArrayAccess;
use ArrayIterator;
use Closure;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * Class AbstractArray
 */
abstract class AbstractArray implements Countable, ArrayAccess, IteratorAggregate
{
    use CreatableTrait;

    use ConvertibleTrait;

    use TraversableTrait;

    use ModifiableTrait;

    use SortableTrait;

    use DebuggableTrait;

    /**
     * @const string
     */
    const DEFAULT_SEPARATOR = '';

    /**
     * @var array
     */
    protected $elements = [];

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
     * Check whether array is empty or no
     *
     * @return bool Whether array is empty or no
     */
    public function isEmpty()
    {
        return !$this->elements;
    }

    /**
     * Check if the given value exists in array
     *
     * @param mixed $element Value to search
     *
     * @return bool Whether array contains given value or no
     */
    public function contains($element)
    {
        return in_array($element, $this->elements, true);
    }

    /**
     * Check if the given key or index exists in array
     *
     * @param mixed $key Key or index to search
     *
     * @return bool Whether array contains given key/index or no
     */
    public function containsKey($key)
    {
        return array_key_exists($key, $this->elements);
    }

    /**
     * Search in array for a given element
     *
     * @param mixed $element Value to search key/index
     *
     * @return mixed The corresponding key or index
     */
    public function indexOf($element)
    {
        return array_search($element, $this->elements, true);
    }

    /**
     * Pick one random element out of array
     * @TODO Maybe rename to getRandomValue() and add getRandomKey()/getRandomArray methods?
     *
     * @return mixed Random element of array
     */
    public function getRandom()
    {
        return $this->offsetGet(array_rand($this->elements, 1));
    }

    /**
     * Return all the keys of array
     *
     * @return array An array of all array keys
     */
    public function getKeys()
    {
        return array_keys($this->elements);
    }

    /**
     * Return all the values of array
     *
     * @return mixed An array of all array values
     */
    public function getValues()
    {
        return array_values($this->elements);
    }

    /**
     * Reindex the array
     *
     * @return static The instance with re-indexed elements
     */
    abstract public function reindex();

    /**
     * Exchanges all array keys with their associated values
     *
     * @return static The instance with flipped elements
     */
    abstract public function flip();

    /**
     * PLace array in reverse order
     *
     * @param bool $preserveKeys Whether array keys are preserved or no
     *
     * @return static The instance with reversed elements
     */
    abstract public function reverse($preserveKeys = false);

    /**
     * Pad array to the specified length with a given value
     *
     * @param int $size Size of result array
     * @param mixed $value Empty value by default
     *
     * @return static The instance with padded elements
     */
    abstract public function pad($size, $value);

    /**
     * Extract a slice of array
     *
     * @param int $offset Offset value of array
     * @param int|null $length Length of sliced array
     * @param bool $preserveKeys Whether array keys are preserved or no
     *
     * @return static The instance with sliced elements
     */
    abstract public function slice($offset, $length = null, $preserveKeys = false);

    /**
     * Split array into chunks
     *
     * @param int $size Size of each chunk
     * @param bool $preserveKeys Whether array keys are preserved or no
     *
     * @return static The instance with splitted elements
     */
    abstract public function chunk($size, $preserveKeys = false);

    /**
     * Removes duplicate values from array
     *
     * @param int|null $sortFlags
     *
     * @return static The instance with unique elements
     */
    abstract public function unique($sortFlags = null);

    /**
     * Merge array with given one
     * @TODO Maybe rename to mergeWith()?
     *
     * @param array $array Array for merge
     * @param bool $recursively Whether array will be merged recursively or no
     *
     * @return static The instance array with merged elements
     */
    abstract public function merge(array $array, $recursively = false);

    /**
     * Replace array with given one
     * @TODO Maybe rename to replaceWith()?
     *
     * @param array $array Array for replace
     * @param bool $recursively Whether array will be replaced recursively or no
     *
     * @return static The instance array with replaced elements
     */
    abstract public function replace(array $array, $recursively = false);

    /**
     * Combine array keys with given array values
     * @TODO Maybe rename to combineWith()?
     *
     * @param array $array Array for combined
     *
     * @return static The instance array with combined elements
     */
    abstract public function combine(array $array);

    /**
     * Compute the difference of array with given one
     * @TODO Maybe rename to diffWith()?
     *
     * @param array $array Array for diff
     *
     * @return static The instance array containing all the entries from array that are not present in given one
     */
    abstract public function diff(array $array);

    /**
     * Shuffle array
     *
     * @return static The instance with shuffled elements
     */
    abstract public function shuffle();

    /**
     * Apply the given function to the array elements
     *
     * @param Closure $func
     *
     * @return static The instance with modified elements
     */
    abstract public function map(Closure $func);

    /**
     * Filter array elements with given function
     *
     * @param Closure $func
     *
     * @return static The instance with filtered elements
     */
    abstract public function filter(Closure $func);

    /**
     * Apply the given function to every array element
     *
     * @param Closure $func
     * @param bool $recursively Whether array will be walked recursively or no
     *
     * @return static The instance with modified elements
     */
    abstract public function walk(Closure $func, $recursively = false);

    /**
     * Iteratively reduce array to a single value using a function
     *
     * @param Closure $func
     * @param mixed|null $initial
     *
     * @return mixed The resulting value
     */
    public function reduce(Closure $func, $initial = null)
    {
        return array_reduce($this->elements, $func, $initial);
    }

    /**
     * Clear array
     *
     * @return static The instance with cleared array
     */
    abstract public function clear();

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

        return $this;
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
