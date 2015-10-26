<?php

namespace Arrayzy;

use ArrayAccess;

/**
 * All methods change the array instance itself
 * and return $this to allow method chaining.
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 */
class ArrayImitatorBuilder
{
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
     * @return ArrayImitator
     */
    public function build()
    {
        return new ArrayImitator($this->elements);
    }

    /**
     * Converts instance to a native PHP array.
     *
     * @return array The native PHP array
     */
    public function toArray()
    {
        return $this->elements;
    }

    // The public static method list order by ASC

    /**
     * Create a new instance.
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
     * Decode a JSON string to new instance.
     *
     * @param string $json The JSON string being decoded
     * @param int $options Bitmask of JSON decode options
     * @param int $depth Specified recursion depth
     *
     * @return static The created array
     */
    public static function createFromJson($json, $options = 0, $depth = 512)
    {
        return new static(json_decode($json, true, $depth, $options));
    }

    /**
     * Create a new instance filled with values from an object implementing ArrayAccess.
     *
     * @param ArrayAccess $elements Object that implements ArrayAccess
     *
     * @return static Returns created instance
     */
    public static function createFromObject(ArrayAccess $elements)
    {
        $array = [];

        foreach ($elements as $key => $value) {
            $array[$key] = $value;
        }

        return new static($array);
    }

    /**
     * Explode a string to new instance by specified separator.
     *
     * @param string $string Converted string
     * @param string $separator Element's separator
     *
     * @return static The created array
     */
    public static function createFromString($string, $separator)
    {
        return new static(explode($separator, $string));
    }

    /**
     * Create a new instance containing a range of elements.
     *
     * @param mixed $low First value of the sequence
     * @param mixed $high The sequence is ended upon reaching the end value
     * @param int $step Used as the increment between elements in the sequence
     *
     * @return static The created array
     */
    public static function createWithRange($low, $high, $step = 1)
    {
        return new static(range($low, $high, $step));
    }

    // The public method list order by ASC

    /**
     * Create a chunked version of this array.
     *
     * @param int $size Size of each chunk
     * @param bool $preserveKeys Whether array keys are preserved or no
     *
     * @return static A new array of chunks from the original array
     */
    public function chunk($size, $preserveKeys = false)
    {
        $this->elements = array_chunk($this->elements, $size, $preserveKeys);

        return $this;
    }

    /**
     * Clear array.
     *
     * @return $this An empty array.
     */
    public function clear()
    {
        $this->elements = [];

        return $this;
    }

    /**
     * Create an array using this array as values and the other array as keys.
     *
     * @param array $array Key array
     *
     * @return static A new array with keys from the other.
     */
    public function combineTo(array $array)
    {
        $this->elements = array_combine($array, $this->elements);

        return $this;
    }

    /**
     * Create an array using this array as keys and the other array as values.
     *
     * @param array $array Values array
     *
     * @return static A new array with values from the other array
     */
    public function combineWith(array $array)
    {
        $this->elements = array_combine($this->elements, $array);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @link http://php.net/manual/en/function.usort.php
     */
    public function customSort(callable $func)
    {
        usort($this->elements, $func);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @link http://php.net/manual/en/function.uksort.php
     */
    public function customSortKeys(callable $func)
    {
        uksort($this->elements, $func);

        return $this;
    }

    /**
     * Compute the array of values not present in the other array.
     *
     * @param array $array Array for diff
     *
     * @return static A new array containing all the entries from this array
     * that are not present in $array
     */
    public function diffWith(array $array)
    {
        $this->elements = array_diff($this->elements, $array);

        return $this;
    }

    /**
     * Filter the array for elements satisfying the predicate $func.
     *
     * @param callable $func
     *
     * @return static A new array with only element satisfying $func
     */
    public function filter(callable $func)
    {
        $this->elements = array_filter($this->elements, $func);

        return $this;
    }

    /**
     * Exchanges all array keys with their associated values.
     *
     * @return static The new instance with flipped elements
     */
    public function flip()
    {
        $this->elements = array_flip($this->elements);

        return $this;
    }

    /**
     * Apply the given function to the every element of the array,
     * collecting the results.
     *
     * @param callable $func
     *
     * @return static A new array with modified elements
     */
    public function map(callable $func)
    {
        $this->elements = array_map($func, $this->elements);

        return $this;
    }

    /**
     * Merges array with the provided one. This array is overwriting.
     *
     * @param array $array Array to merge with (is overwritten)
     * @param bool $recursively Whether array will be merged recursively or no
     *
     * @return static A new array with the keys/values
     * from $array added, that weren't present in the original
     */
    public function mergeTo(array $array, $recursively = false)
    {
        if (true === $recursively) {
            $this->elements = array_merge_recursive($array, $this->elements);
        } else {
            $this->elements = array_merge($array, $this->elements);
        }

        return $this;
    }

    /**
     * Merges this array with the provided one. Latter array is overwriting.
     *
     * @param array $array Array to merge with (overwrites)
     * @param bool $recursively Whether array will be merged recursively or no
     *
     * @return static A new array with the keys/values from $array added
     */
    public function mergeWith(array $array, $recursively = false)
    {
        if (true === $recursively) {
            $this->elements = array_merge_recursive($this->elements, $array);
        } else {
            $this->elements = array_merge($this->elements, $array);
        }

        return $this;
    }

    /**
     * Pad array to the specified size with a given value.
     *
     * @param int $size Size of the result array
     * @param mixed $value Empty value by default
     *
     * @return static A new array padded to $size with $value
     */
    public function pad($size, $value)
    {
        $this->elements = array_pad($this->elements, $size, $value);

        return $this;
    }

    /**
     * Pop a specified value off the end of array.
     *
     * @return mixed The popped element
     */
    public function pop()
    {
        return array_pop($this->elements);
    }

    /**
     * Push one or more values onto the end of array at once.
     *
     * @param mixed $element The pushed element
     * @param mixed $_ [optional] Multiple arguments allowed
     *
     * @return $this An array with pushed elements
     * to the end of array
     */
    public function push($element, $_ = null)
    {
        if (func_num_args()) {
            $args = array_merge([&$this->elements], func_get_args());
            call_user_func_array('array_push', $args);
        }

        return $this;
    }

    /**
     * Create a numerically re-indexed array.
     *
     * @return static The new instance with re-indexed elements
     */
    public function reindex()
    {
        $this->elements = array_values($this->elements);

        return $this;
    }

    /**
     * Replace the entire array with the other one except keys present in both.
     * For keys present in both arrays the value from this array will be used.
     *
     * @param array $array Array to replace with
     * @param bool $recursively Whether array will be replaced recursively or no
     *
     * @return static A new array with keys from $array and values from both.
     */
    public function replaceIn(array $array, $recursively = false)
    {
        if (true === $recursively) {
            $this->elements = array_replace_recursive($array, $this->elements);
        } else {
            $this->elements = array_replace($array, $this->elements);
        }

        return $this;
    }

    /**
     * Replace values in this array with values in the other array
     * that have the same key.
     *
     * @param array $array Array of replacing values
     * @param bool $recursively Whether array will be replaced recursively or no
     *
     * @return static A new array with the same keys but new values
     */
    public function replaceWith(array $array, $recursively = false)
    {
        if (true === $recursively) {
            $this->elements = array_replace_recursive($this->elements, $array);
        } else {
            $this->elements = array_replace($this->elements, $array);
        }

        return $this;
    }

    /**
     * Reverse the order of the array values.
     *
     * @param bool $preserveKeys Whether array keys are preserved or no
     *
     * @return static A new array with the order of the elements reversed
     */
    public function reverse($preserveKeys = false)
    {
        $this->elements = array_reverse($this->elements, $preserveKeys);

        return $this;
    }

    /**
     * Shifts a specified value off the beginning of array.
     *
     * @return mixed A shifted element
     */
    public function shift()
    {
        return array_shift($this->elements);
    }

    /**
     * Randomize element order.
     *
     * @return $this An array with the element order shuffled
     */
    public function shuffle()
    {
        shuffle($this->elements);

        return $this;
    }

    /**
     * Extract a slice of the array.
     *
     * @param int $offset Slice begin index
     * @param int|null $length Length of the slice
     * @param bool $preserveKeys Whether array keys are preserved or no
     *
     * @return static A slice of the original array with length $length
     */
    public function slice($offset, $length = null, $preserveKeys = false)
    {
        $this->elements = array_slice($this->elements, $offset, $length, $preserveKeys);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @link http://php.net/manual/en/function.arsort.php
     * @link http://php.net/manual/en/function.sort.php
     * @link http://php.net/manual/en/function.asort.php
     * @link http://php.net/manual/en/function.rsort.php
     */
    public function sort($order = SORT_ASC, $strategy = SORT_REGULAR, $preserveKeys = false)
    {
        $this->sorting($this->elements, $order, $strategy, $preserveKeys);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @link http://php.net/manual/en/function.ksort.php
     * @link http://php.net/manual/en/function.krsort.php
     */
    public function sortKeys($order = SORT_ASC, $strategy = SORT_REGULAR)
    {
        $this->sortingKeys($this->elements, $order, $strategy);

        return $this;
    }

    /**
     * Removes duplicate values from the array.
     *
     * @param int|null $sortFlags
     *
     * @return static A new array with only unique elements
     */
    public function unique($sortFlags = null)
    {
        $this->elements = array_unique($this->elements, $sortFlags);

        return $this;
    }

    /**
     * Prepends one or more values to the beginning of array at once.
     *
     * @param mixed $element The element for prepend
     * @param mixed $_ [optional] Multiple arguments allowed
     *
     * @return $this A new array with prepended elements to the beginning of array
     */
    public function unshift($element, $_ = null)
    {
        if (func_num_args()) {
            $args = array_merge([&$this->elements], func_get_args());
            call_user_func_array('array_unshift', $args);
        }

        return $this;
    }

    /**
     * Apply the given function to every element in the array,
     * discarding the results.
     *
     * @param callable $func
     * @param bool $recursively Whether array will be walked recursively or no
     *
     * @return $this An array with modified elements
     */
    public function walk(callable $func, $recursively = false)
    {
        if (true === $recursively) {
            array_walk_recursive($this->elements, $func);
        } else {
            array_walk($this->elements, $func);
        }

        return $this;
    }

    // protected method list order by ASC
    /**
     * @param array &$elements
     * @param int $order
     * @param int $strategy
     * @param bool $preserveKeys
     */
    protected function sorting(array &$elements, $order = SORT_ASC, $strategy = SORT_REGULAR, $preserveKeys = false)
    {
        switch ($order) {
            case SORT_DESC:
                if ($preserveKeys) {
                    arsort($elements, $strategy);
                } else {
                    rsort($elements, $strategy);
                }
                break;

            case SORT_ASC:
            default:
                if ($preserveKeys) {
                    asort($elements, $strategy);
                } else {
                    sort($elements, $strategy);
                }
        }
    }

    /**
     * @param array &$elements
     * @param int $order
     * @param int $strategy
     */
    protected function sortingKeys(array &$elements, $order = SORT_ASC, $strategy = SORT_REGULAR)
    {
        switch ($order) {
            case SORT_DESC:
                krsort($elements, $strategy);
                break;

            case SORT_ASC:
            default:
                ksort($elements, $strategy);
        }
    }
}
