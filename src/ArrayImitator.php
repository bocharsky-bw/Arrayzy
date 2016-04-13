<?php

namespace Arrayzy;

/**
 * Some methods could change the array instance itself
 * and some could return a new instance of ObjectOrientedArray.
 * This class repeats the PHP built-in functions behavior.
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 */
class ArrayImitator extends AbstractArray
{
    // The public method list ordered by ASC

    /**
     * Add a new element to the current array.
     *
     * @param mixed $element
     *
     * @return ArrayImitator The current array with added value
     */
    public function add($element)
    {
        $this->elements[] = $element;

        return $this;
    }

    /**
     * Create a chunked version of current array.
     *
     * @param int $size Size of each chunk
     * @param bool $preserveKeys Whether array keys are preserved or no
     *
     * @return ArrayImitator A new array of chunks from the current array
     */
    public function chunk($size, $preserveKeys = false)
    {
        return new static(array_chunk($this->elements, $size, $preserveKeys));
    }

    /**
     * Clear the current array.
     *
     * @return ArrayImitator The current empty array
     */
    public function clear()
    {
        $this->elements = [];

        return $this;
    }

    /**
     * Create an array using the current array as keys and the other array as values.
     *
     * @param array $array Values array
     *
     * @return ArrayImitator A new array with values from the other array
     */
    public function combine(array $array)
    {
        return new static(array_combine($this->elements, $array));
    }

    /**
     * Compute the current array values which not present in the given one.
     *
     * @param array $array Array for diff
     *
     * @return ArrayImitator A new array containing all the entries from this array
     * that are not present in $array
     */
    public function diff(array $array)
    {
        return new static(array_diff($this->elements, $array));
    }

    /**
     * Filter the current array for elements satisfying the predicate $func.
     *
     * @param callable $func
     *
     * @return ArrayImitator A new array with only element satisfying $func
     */
    public function filter(callable $func)
    {
        return new static(array_filter($this->elements, $func));
    }

    /**
     * Exchanges all keys of current array with their associated values.
     *
     * @return ArrayImitator A new array with flipped elements
     */
    public function flip()
    {
        return new static(array_flip($this->elements));
    }

    /**
     * Compute the current array values which present in the given one.
     *
     * @param array $array Array for intersect
     *
     * @return ArrayImitator An array with containing all the entries from this array
     * that are present in $array
     */
    public function intersect(array $array)
    {
        return new static(array_intersect($this->elements, $array));
    }

    /**
     * Compute the current array values with additional index check
     *
     * @param array $array Array for intersect
     *
     * @return ArrayImitator An array with containing all the entries from this array
     * that are present in $array. Note that the keys are also used in the comparison
     * unlike in intersect().
     */
    public function intersectAssoc(array $array)
    {
        return new static(array_intersect_assoc($this->elements, $array));
    }

    /**
     * Compute the current array using keys for comparison which present in the given one.
     *
     * @param array $array Array for intersect
     *
     * @return ArrayImitator An array with containing all the entries from this array
     * which have keys that are present in $array.
     */
    public function intersectKey(array $array)
    {
        return new static(array_intersect_key($this->elements, $array));
    }

    /**
     * Apply the given function to the every element of the current array,
     * collecting the results.
     *
     * @param callable $func
     *
     * @return ArrayImitator A new array with modified elements
     */
    public function map(callable $func)
    {
        return new static(array_map($func, $this->elements));
    }

    /**
     * Merge the current array with the provided one. The latter array is overwriting.
     *
     * @param array $array Array to merge with (overwrites)
     * @param bool $recursively Whether array will be merged recursively or no
     *
     * @return ArrayImitator A new array with the keys/values from $array added
     */
    public function merge(array $array, $recursively = false)
    {
        if (true === $recursively) {
            return new static(array_merge_recursive($this->elements, $array));
        }

        return new static(array_merge($this->elements, $array));
    }

    /**
     * Pad the current array to the specified size with a given value.
     *
     * @param int $size Size of the result array
     * @param mixed $value Empty value by default
     *
     * @return ArrayImitator A new array padded to $size with $value
     */
    public function pad($size, $value)
    {
        return new static(array_pad($this->elements, $size, $value));
    }

    /**
     * Create a numerically re-indexed array based on the current array.
     *
     * @return ArrayImitator A new array with re-indexed elements
     */
    public function reindex()
    {
        return new static(array_values($this->elements));
    }

    /**
     * Replace values in the current array with values in the given one
     * that have the same key.
     *
     * @param array $array Array of replacing values
     * @param bool $recursively Whether array will be replaced recursively or no
     *
     * @return ArrayImitator A new array with the same keys but new values
     */
    public function replace(array $array, $recursively = false)
    {
        if (true === $recursively) {
            return new static(array_replace_recursive($this->elements, $array));
        }

        return new static(array_replace($this->elements, $array));
    }

    /**
     * Reverse the values order of the current array.
     *
     * @param bool $preserveKeys Whether array keys are preserved or no
     *
     * @return ArrayImitator A new array with the order of the elements reversed
     */
    public function reverse($preserveKeys = false)
    {
        return new static(array_reverse($this->elements, $preserveKeys));
    }

    /**
     * Randomize elements order of the current array.
     *
     * @return ArrayImitator The current array with the shuffled elements order
     */
    public function shuffle()
    {
        shuffle($this->elements);

        return $this;
    }

    /**
     * Extract a slice of the current array.
     *
     * @param int $offset Slice begin index
     * @param int|null $length Length of the slice
     * @param bool $preserveKeys Whether array keys are preserved or no
     *
     * @return ArrayImitator A new array, which is slice of the current array
     * with specified $length
     */
    public function slice($offset, $length = null, $preserveKeys = false)
    {
        return new static(array_slice($this->elements, $offset, $length, $preserveKeys));
    }

    /**
     * Remove duplicate values from the current array.
     *
     * @param int|null $sortFlags
     *
     * @return ArrayImitator A new array with only unique elements
     */
    public function unique($sortFlags = null)
    {
        return new static(array_unique($this->elements, $sortFlags));
    }

    /**
     * Apply the given function to the every element of the current array,
     * discarding the results.
     *
     * @param callable $func
     * @param bool $recursively Whether array will be walked recursively or no
     *
     * @return ArrayImitator The current array with modified elements
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
}
