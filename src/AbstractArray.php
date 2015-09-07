<?php

namespace Arrayzy;

use Arrayzy\Interfaces\ConvertibleInterface;
use Arrayzy\Interfaces\DebuggableInterface;
use Arrayzy\Interfaces\ModifiableInterface;
use Arrayzy\Interfaces\SortableInterface;
use Arrayzy\Interfaces\TraversableInterface;
use Arrayzy\Traits\ConvertibleTrait;
use Arrayzy\Traits\DebuggableTrait;
use Arrayzy\Traits\ModifiableTrait;
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
abstract class AbstractArray implements
    ArrayAccess,
    ConvertibleInterface,
    Countable,
    DebuggableInterface,
    IteratorAggregate,
    ModifiableInterface,
    SortableInterface,
    TraversableInterface
{
    use ConvertibleTrait;

    use DebuggableTrait;

    use ModifiableTrait;

    use TraversableTrait;

    /**
     * @const string
     */
    const DEFAULT_SEPARATOR = ', ';

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
            $array[$key] = $value;
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
     * Clone current instance to new instance
     *
     * @return $this Returns cloned instance
     */
    public function createClone()
    {
        return clone $this;
    }

    /**
     * Check whether array is empty or no
     *
     * @return bool Returns true if empty, false otherwise
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
     * @return bool Returns true if the given value exists in array, false otherwise
     */
    public function contains($element)
    {
        return in_array($element, $this->elements, true);
    }

    /**
     * Check if the given key/index exists in array
     *
     * @param mixed $key Key/index to search
     *
     * @return bool Returns true if the given key/index exists in array, false otherwise
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
     * @return mixed The corresponding key/index
     */
    public function indexOf($element)
    {
        return array_search($element, $this->elements, true);
    }

    /**
     * Pick a random key/index out key of array
     *
     * @return mixed Random key/index of array
     *
     * @throws \LogicException
     */
    public function getRandomKey()
    {
        if (1 >= $this->count()) {
            throw new \LogicException(sprintf(
                'The number of elements in the array "%d" should be greater than "1".', $this->count()
            ));
        }

        return array_rand($this->elements, 1);
    }

    /**
     * Pick a random value out of array
     *
     * @return mixed Random value of array
     *
     * @throws \LogicException
     */
    public function getRandom()
    {
        return $this->offsetGet($this->getRandomKey());
    }

    /**
     * Pick a given number of random keys/indexes out of array
     *
     * @param int $number The number of keys/indexes (should be > 1 and < $this->count())
     *
     * @return array Random keys of array
     *
     * @throws \RangeException
     * @throws \LogicException
     */
    public function getRandomKeys($number)
    {
        $number = (int) $number;
        $count = $this->count();
        if ($number < 1 || $number > $count) {
            throw new \RangeException(sprintf(''
                . 'The given number "%d" should be greater than or equal to "1" '
                . 'and less than or equal to "%d" (the number of elements in the array).',
                $number,
                $count
            ));
        }
        if ($number === 1 || $number === $count) {
            throw new \LogicException(sprintf(
                'The given number "%d" should not be equal to "1" or "%d" (the number of elements in the array).',
                $number,
                $count
            ));
        }

        return array_rand($this->elements, $number);
    }

    /**
     * Pick a given number of random values out of array
     *
     * @param int $number The number of values (should be > 1 and < $this->count())
     *
     * @return array Random values of array
     *
     * @throws \RangeException
     * @throws \LogicException
     */
    public function getRandomValues($number)
    {
        $values = [];
        foreach ($this->getRandomKeys($number) as $key) {
            $values[] = $this->offsetGet($key);
        }

        return $values;
    }

    /**
     * Return all the keys of array
     *
     * @return array An array of all keys
     */
    public function getKeys()
    {
        return array_keys($this->elements);
    }

    /**
     * Return all the values of array
     *
     * @return mixed An array of all values
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
     * Pad array to the specified size with a given value
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
     *
     * @param array $array Array for merge
     * @param bool $recursively Whether array will be merged recursively or no
     *
     * @return static The instance array with merged elements
     */
    abstract public function mergeWith(array $array, $recursively = false);

    /**
     * Replace array with given one
     *
     * @param array $array Array for replace
     * @param bool $recursively Whether array will be replaced recursively or no
     *
     * @return static The instance array with replaced elements
     */
    abstract public function replaceWith(array $array, $recursively = false);

    /**
     * Combine array keys with given array values
     *
     * @param array $array Array for combined
     *
     * @return static The instance array with combined elements
     */
    abstract public function combineWith(array $array);

    /**
     * Compute the difference of array with given one
     *
     * @param array $array Array for diff
     *
     * @return static The instance array containing all the entries from array that are not present in given one
     */
    abstract public function diffWith(array $array);

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
