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
     * @return array The array with re-indexed elements
     */
    public function reindex()
    {
        return array_values($this->elements);
    }

    /**
     * Exchanges all array keys with their associated values
     *
     * @return array The array with flipped elements
     */
    public function flip()
    {
        return array_flip($this->elements);
    }

    /**
     * PLace array in reverse order
     *
     * @param bool $preserveKeys Whether array keys are preserved or no
     *
     * @return array The array with reversed elements
     */
    public function reverse($preserveKeys = false)
    {
        return array_reverse($this->elements, $preserveKeys);
    }

    /**
     * Pad array to the specified length with a given value
     *
     * @param int $size Size of result array
     * @param mixed $value Empty value by default
     *
     * @return array The array with padded elements
     */
    public function pad($size, $value)
    {
        return array_pad($this->elements, $size, $value);
    }

    /**
     * Extract a slice of array
     *
     * @param int $offset Offset value of array
     * @param int|null $length Length of sliced array
     * @param bool $preserveKeys Whether array keys are preserved or no
     *
     * @return array The array with sliced elements
     */
    public function slice($offset, $length = null, $preserveKeys = false)
    {
        return array_slice($this->elements, $offset, $length, $preserveKeys);
    }

    /**
     * Split array into chunks
     *
     * @param int $size Size of each chunk
     * @param bool $preserveKeys Whether array keys are preserved or no
     *
     * @return array The array with splitted elements
     */
    public function chunk($size, $preserveKeys = false)
    {
        return array_chunk($this->elements, $size, $preserveKeys);
    }

    /**
     * Removes duplicate values from array
     *
     * @param int|null $sortFlags
     *
     * @return array The array with unique elements
     */
    public function unique($sortFlags = null)
    {
        return array_unique($this->elements, $sortFlags);
    }

    /**
     * Merge array with given one
     * @TODO Maybe rename to mergeWith()?
     *
     * @param array $array Array for merge
     * @param bool $recursively Whether array will be merged recursively or no
     *
     * @return array The result array with merged elements
     */
    public function merge(array $array, $recursively = false)
    {
        if (true === $recursively) {
            return array_merge_recursive($this->elements, $array);
        }

        return array_merge($this->elements, $array);
    }

    /**
     * Replace array with given one
     * @TODO Maybe rename to replaceWith()?
     *
     * @param array $array Array for replace
     * @param bool $recursively Whether array will be replaced recursively or no
     *
     * @return array The result array with replaced elements
     */
    public function replace(array $array, $recursively = false)
    {
        if (true === $recursively) {
            return array_replace_recursive($this->elements, $array);
        }

        return array_replace($this->elements, $array);
    }

    /**
     * Combine array keys with given array values
     * @TODO Maybe rename to combineWith()?
     *
     * @param array $array Array for combined
     *
     * @return array The result array with combined elements
     */
    public function combine(array $array)
    {
        return array_combine($this->elements, $array);
    }

    /**
     * Compute the difference of array with given one
     * @TODO Maybe rename to diffWith()?
     *
     * @param array $array Array for diff
     *
     * @return array The result array containing all the entries from array that are not present in given one
     */
    public function diff(array $array)
    {
        return array_diff($this->elements, $array);
    }

    /**
     * Shuffle array
     *
     * @return static The instance with shuffled elements
     */
    abstract public function shuffle();

    /**
     * Apply the given callback to the array elements
     *
     * @param callable $callable
     *
     * @return array The array with modified elements
     */
    public function map(Closure $callable)
    {
        return array_map($callable, $this->elements);
    }

    /**
     * Filter array elements with given callback
     *
     * @param callable $callable
     *
     * @return array The array with filtered elements
     */
    public function filter(Closure $callable)
    {
        return array_filter($this->elements, $callable);
    }

    /**
     * Apply the given callback to every array element
     *
     * @param callable $callable
     * @param bool $recursively Whether array will be walked recursively or no
     *
     * @return static The instance with modified elements
     */
    abstract public function walk(Closure $callable, $recursively = false);

    /**
     * Iteratively reduce array to a single value using a callback function
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
     * Clear array
     *
     * @return array The cleared array
     */
    public function clear()
    {
        return [];
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
