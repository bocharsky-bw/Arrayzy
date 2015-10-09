<?php

namespace Arrayzy;

/**
 * Class ImmutableArray
 *
 * None of the methods change the array instance itself and instead return
 * a new ImmutableArray.
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 */
class ImmutableArray extends AbstractArray
{
    /**
     * Create a numerically reindexed array.
     *
     * @return static The new instance with re-indexed elements
     */
    public function reindex()
    {
        return new static(array_values($this->elements));
    }

    /**
     * Exchanges all array keys with their associated values.
     *
     * @return static The new instance with flipped elements
     */
    public function flip()
    {
        return new static(array_flip($this->elements));
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
        return new static(array_reverse($this->elements, $preserveKeys));
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
        return new static(array_pad($this->elements, $size, $value));
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
        return new static(array_slice($this->elements, $offset, $length, $preserveKeys));
    }

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
        return new static(array_chunk($this->elements, $size, $preserveKeys));
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
        return new static(array_unique($this->elements, $sortFlags));
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
            return new static(array_merge_recursive($this->elements, $array));
        }

        return new static(array_merge($this->elements, $array));
    }

    /**
     * Merges array with the provided one. This array is overwriting.
     *
     * @param array $array Array to merge with (is overwritten)
     * @param bool $recursively Whether array will be merged recursively or no
     *
     * @return static An array with the keys/values from $array added, that weren't present in the original
     */
    public function mergeTo(array $array, $recursively = false)
    {
        if (true === $recursively) {
            return new static(array_merge_recursive($array, $this->elements));
        }

        return new static(array_merge($array, $this->elements));
    }

    /**
     * Push one or more values onto the end of array at once.
     *
     * @param mixed $element The pushed element
     * @param mixed $_ [optional] Multiple arguments allowed
     *
     * @return static The new instance with pushed elements to the end of array
     */
    public function push($element, $_ = null)
    {
        $elements = $this->elements;
        if (func_num_args()) {
            $args = array_merge([&$elements], func_get_args());
            call_user_func_array('array_push', $args);
        }

        return new static($elements);
    }

    /**
     * Pop a specified value off the end of array.
     *
     * @return mixed The popped element
     */
    public function pop()
    {
        return $this->count() ? $this->last() : null;
    }

    /**
     * Replace values in this array with values in the other array that have the
     * same key.
     *
     * @param array $array Array of replacing values
     * @param bool $recursively Whether array will be replaced recursively or no
     *
     * @return static A new array with the same keys but new values
     */
    public function replaceWith(array $array, $recursively = false)
    {
        if (true === $recursively) {
            return new static(array_replace_recursive($this->elements, $array));
        }

        return new static(array_replace($this->elements, $array));
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
            return new static(array_replace_recursive($array, $this->elements));
        }

        return new static(array_replace($array, $this->elements));
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
        return new static(array_combine($this->elements, $array));
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
        return new static(array_combine($array, $this->elements));
    }

    /**
     * Compute the array of values not present in the other array.
     *
     * @param array $array Array for diff
     *
     * @return static An array containing all the entries from this array that are not present in $array
     */
    public function diffWith(array $array)
    {
        return new static(array_diff($this->elements, $array));
    }

    /**
     * Unshift array
     *
     * @param mixed $element The element for prepend
     * @param mixed $_ [optional] Multiple arguments allowed
     *
     * @return static The new instance with prepended elements to the beginning of array
     */
    public function unshift($element, $_ = null)
    {
        $elements = $this->elements;
        if (func_num_args()) {
            $args = array_merge([&$elements], func_get_args());
            call_user_func_array('array_unshift', $args);
        }

        return new static($elements);
    }

    /**
     * Shifts a specified value off the beginning of array.
     *
     * @return mixed The shifted element
     */
    public function shift()
    {
        return $this->count() ? $this->first() : null;
    }

    /**
     * Randomize element order.
     *
     * @return static A new array with the elemant order shuffled
     */
    public function shuffle()
    {
        $elements = $this->elements;

        shuffle($elements);

        return new static($elements);
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
        $elements = $this->elements;
        parent::sorting($elements, $order, $strategy, $preserveKeys);

        return new static($elements);
    }

    /**
     * {@inheritdoc}
     *
     * @link http://php.net/manual/en/function.ksort.php
     * @link http://php.net/manual/en/function.krsort.php
     */
    public function sortKeys($order = SORT_ASC, $strategy = SORT_REGULAR)
    {
        $elements = $this->elements;
        parent::sortingKeys($elements, $order, $strategy);

        return new static($elements);
    }

    /**
     * Apply the given function to the every element of the array, collecting the results.
     *
     * @param callable $func
     *
     * @return static A new array with modified elements
     */
    public function map(callable $func)
    {
        return new static(array_map($func, $this->elements));
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
        return new static(array_filter($this->elements, $func));
    }

    /**
     * Apply the given function to every element in the array, discarding the results.
     *
     * @param callable $func
     * @param bool $recursively Whether array will be walked recursively or no
     *
     * @return static The new instance with modified elements
     */
    public function walk(callable $func, $recursively = false)
    {
        $elements = $this->elements;

        if (true === $recursively) {
            array_walk_recursive($elements, $func);
        } else {
            array_walk($elements, $func);
        }

        return new static($elements);
    }

    /**
     * {@inheritdoc}
     *
     * @link http://php.net/manual/en/function.usort.php
     */
    public function customSort(callable $func)
    {
        $elements = $this->elements;

        usort($elements, $func);

        return new static($elements);
    }

    /**
     * {@inheritdoc}
     *
     * @link http://php.net/manual/en/function.uksort.php
     */
    public function customSortKeys(callable $func)
    {
        $elements = $this->elements;

        uksort($elements, $func);

        return new static($elements);
    }

    /**
     * Clear array.
     *
     * @return static A new empty array.
     */
    public function clear()
    {
        return new static();
    }
}
