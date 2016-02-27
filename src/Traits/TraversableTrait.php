<?php

namespace Arrayzy\Traits;

/**
 * Trait with helpful methods for traversing array.
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 *
 * @property array $elements
 */
trait TraversableTrait
{
    /**
     * Sets the internal pointer of an array to its first element.
     *
     * @return mixed The value of the first array element, or false if the array is empty.
     *
     * @link http://php.net/manual/en/function.reset.php
     */
    public function reset()
    {
        return reset($this->elements);
    }

    /**
     * Alias of reset() method. Sets the internal pointer of an array to its first element.
     *
     * @return mixed The value of the first array element, or false if the array is empty.
     *
     * @link http://php.net/manual/en/function.reset.php
     */
    public function first()
    {
        return $this->reset();
    }

    /**
     * Sets the internal pointer of an array to its last element.
     *
     * @return mixed The value of the last array element, or false if the array is empty.
     *
     * @link http://php.net/manual/en/function.end.php
     */
    public function end()
    {
        return end($this->elements);
    }

    /**
     * Alias of end() method. Sets the internal pointer of an array to its last element.
     *
     * @return mixed The value of the last array element, or false if the array is empty.
     *
     * @link http://php.net/manual/en/function.end.php
     */
    public function last()
    {
        return $this->end();
    }

    /**
     * Advances the internal array pointer of an array.
     *
     * @return mixed The array value in the next place that's pointed
     * to by the internal array pointer, or false if there are no more elements.
     *
     * @link http://php.net/manual/en/function.next.php
     */
    public function next()
    {
        return next($this->elements);
    }

    /**
     * Rewinds the internal array pointer.
     *
     * @return mixed The array value in the previous place that's pointed
     * to by the internal array pointer, or false if there are no more elements.
     *
     * @link http://php.net/manual/en/function.prev.php
     */
    public function previous()
    {
        return prev($this->elements);
    }

    /**
     * Fetch a key from an array.
     *
     * @return mixed The key function simply returns the key of the array element
     * that's currently being pointed to by the internal pointer. It does not move
     * the pointer in any way. If the internal pointer points beyond the end
     * of the elements list or the array is empty, key returns null.
     *
     * @link http://php.net/manual/en/function.key.php
     */
    public function key()
    {
        return key($this->elements);
    }

    /**
     * Returns the current element in an array.
     *
     * @return mixed The current function simply returns the value of the array element
     * that's currently being pointed to by the internal pointer. It does not move
     * the pointer in any way. If the internal pointer points beyond the end
     * of the elements list or the array is empty, current returns false.
     *
     * @link http://php.net/manual/en/function.current.php
     */
    public function current()
    {
        return current($this->elements);
    }

    /**
     * Returns the current key and value pair from an array and advance the array cursor.
     *
     * @return array The current key and value pair from the array array.
     * This pair is returned in a four-element array, with the keys 0, 1, key, and value.
     * Elements 0 and key contain the key name of the array element, and 1 and value contain the data.
     * If the internal pointer for the array points past the end of the array contents, each returns false.
     *
     * @link http://php.net/manual/en/function.each.php
     */
    public function each()
    {
        return each($this->elements);
    }
}
