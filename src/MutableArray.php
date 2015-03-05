<?php

namespace Arrayzy;

use Closure;

/**
 * Class MutableArray
 */
class MutableArray extends AbstractArray
{
    /**
     * Reindex the array
     *
     * @return $this The same instance with re-indexed elements
     */
    public function reindex()
    {
        $this->elements = array_values($this->elements);

        return $this;
    }

    /**
     * Exchanges all array keys with their associated values
     *
     * @return $this The same instance with flipped elements
     */
    public function flip()
    {
        $this->elements = array_flip($this->elements);

        return $this;
    }

    /**
     * PLace array in reverse order
     *
     * @param bool $preserveKeys Whether array keys are preserved or no
     *
     * @return $this The same instance with reversed elements
     */
    public function reverse($preserveKeys = false)
    {
        $this->elements = array_reverse($this->elements, $preserveKeys);

        return $this;
    }

    /**
     * Pad array to the specified length with a given value
     *
     * @param int $size Size of result array
     * @param mixed $value Empty value by default
     *
     * @return $this The same instance with padded elements
     */
    public function pad($size, $value)
    {
        $this->elements = array_pad($this->elements, $size, $value);

        return $this;
    }

    /**
     * Extract a slice of array
     *
     * @param int $offset Offset value of array
     * @param int|null $length Length of sliced array
     * @param bool $preserveKeys Whether array keys are preserved or no
     *
     * @return $this The same instance with sliced elements
     */
    public function slice($offset, $length = null, $preserveKeys = false)
    {
        $this->elements = array_slice($this->elements, $offset, $length, $preserveKeys);

        return $this;
    }

    /**
     * Split array into chunks
     *
     * @param int $size Size of each chunk
     * @param bool $preserveKeys Whether array keys are preserved or no
     *
     * @return $this The same instance with splitted elements
     */
    public function chunk($size, $preserveKeys = false)
    {
        $this->elements = array_chunk($this->elements, $size, $preserveKeys);

        return $this;
    }

    /**
     * Removes duplicate values from array
     *
     * @param int|null $sortFlags
     *
     * @return $this The same instance with unique elements
     */
    public function unique($sortFlags = null)
    {
        $this->elements = array_unique($this->elements, $sortFlags);

        return $this;
    }

    /**
     * Merge array with given one
     *
     * @param array $array Array for merge
     * @param bool $recursively Whether array will be merged recursively or no
     *
     * @return $this The same instance with merged elements
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
     * Replace array with given one
     *
     * @param array $array Array for replace
     * @param bool $recursively Whether array will be replaced recursively or no
     *
     * @return $this The same instance with replaced elements
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
     * Combine array keys with given array values
     *
     * @param array $array Array for combined
     *
     * @return $this The same instance with combined elements
     */
    public function combine(array $array)
    {
        $this->elements = array_combine($this->elements, $array);

        return $this;
    }

    /**
     * Compute the difference of array with given one
     *
     * @param array $array Array for diff
     *
     * @return $this The same instance containing all the entries from array that are not present in given one
     */
    public function diff(array $array)
    {
        $this->elements = array_diff($this->elements, $array);

        return $this;
    }

    /**
     * Shuffle array
     *
     * @return $this The same instance with shuffled elements
     */
    public function shuffle()
    {
        shuffle($this->elements);

        return $this;
    }

    /**
     * Sort array by values
     *
     * @param int $order The order direction:
     * <ul>
     * <li>SORT_ASC</li>
     * <li>SORT_DESC</li>
     * </ul>
     * @param int $strategy The order behavior:
     * <ul>
     * <li>SORT_REGULAR</li>
     * <li>SORT_NUMERIC</li>
     * <li>SORT_STRING</li>
     * <li>SORT_LOCALE_STRING</li>
     * <li>SORT_NATURAL</li>
     * <li>SORT_FLAG_CASE</li>
     * </ul>
     * @param bool $preserveKeys Maintain index association
     * @link http://php.net/manual/en/function.sort.php
     *
     * @return $this The same instance with sorted elements
     */
    public function sort($order = SORT_ASC, $strategy = SORT_REGULAR, $preserveKeys = false)
    {
        switch ($order) {
            case SORT_DESC:
                if ($preserveKeys) {
                    arsort($this->elements, $strategy);
                } else {
                    rsort($this->elements, $strategy);
                }
                break;

            case SORT_ASC:
            default:
                if ($preserveKeys) {
                    asort($this->elements, $strategy);
                } else {
                    sort($this->elements, $strategy);
                }
        }

        return $this;
    }

    /**
     * Sort array by keys
     *
     * @param int $order The order direction:
     * <ul>
     * <li>SORT_ASC</li>
     * <li>SORT_DESC</li>
     * </ul>
     * @param int $strategy The order behavior:
     * <ul>
     * <li>SORT_REGULAR</li>
     * <li>SORT_NUMERIC</li>
     * <li>SORT_STRING</li>
     * <li>SORT_LOCALE_STRING</li>
     * <li>SORT_NATURAL</li>
     * <li>SORT_FLAG_CASE</li>
     * </ul>
     * @link http://php.net/manual/en/function.sort.php
     *
     * @return $this The same instance with sorted elements
     */
    public function sortKeys($order = SORT_ASC, $strategy = SORT_REGULAR)
    {
        switch ($order) {
            case SORT_DESC:
                krsort($this->elements, $strategy);
                break;

            case SORT_ASC:
            default:
                ksort($this->elements, $strategy);
        }

        return $this;
    }

    /**
     * Apply the given function to the array elements
     *
     * @param Closure $func
     *
     * @return $this The same instance with modified elements
     */
    public function map(Closure $func)
    {
        $this->elements = array_map($func, $this->elements);

        return $this;
    }

    /**
     * Filter array elements with given function
     *
     * @param Closure $func
     *
     * @return $this The same instance with filtered elements
     */
    public function filter(Closure $func)
    {
        $this->elements = array_filter($this->elements, $func);

        return $this;
    }

    /**
     * Apply the given function to every array element
     *
     * @param Closure $func
     * @param bool $recursively Whether array will be walked recursively or no
     *
     * @return $this The same instance with modified elements
     */
    public function walk(Closure $func, $recursively = false)
    {
        if (true === $recursively) {
            array_walk_recursive($this->elements, $func);
        } else {
            array_walk($this->elements, $func);
        }

        return $this;
    }

    /**
     * Sort the array elements with a user-defined comparison function and maintain index association
     *
     * @param Closure $func
     *
     * @return $this The same instance with custom sorted elements
     */
    public function customSort(Closure $func)
    {
        usort($this->elements, $func);

        return $this;
    }

    /**
     * Sort the array keys with a user-defined comparison function and maintain index association
     *
     * @param Closure $func
     *
     * @return $this The same instance with custom sorted elements
     */
    public function customSortKeys(Closure $func)
    {
        uksort($this->elements, $func);

        return $this;
    }

    /**
     * Clear array
     *
     * @return $this The same instance with cleared elements
     */
    public function clear()
    {
        $this->elements = [];

        return $this;
    }
}
