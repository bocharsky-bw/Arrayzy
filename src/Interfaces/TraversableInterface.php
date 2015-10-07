<?php

namespace Arrayzy\Interfaces;

use Traversable;

/**
 * An interface with helpful array traversing methods.
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 */
interface TraversableInterface extends Traversable
{
    /**
     * Sets the internal pointer of an array to its first element.
     *
     * @return mixed The value of the first array element, or false if the array is empty.
     */
    public function first();

    /**
     * Sets the internal pointer of an array to its last element.
     *
     * @return mixed The value of the last array element, or false if the array is empty.
     */
    public function last();

    /**
     * Advances the internal array pointer of an array.
     *
     * @return mixed The array value in the next place that's pointed
     * to by the internal array pointer, or false if there are no more elements.
     */
    public function next();

    /**
     * Rewinds the internal array pointer.
     *
     * @return mixed The array value in the previous place that's pointed
     * to by the internal array pointer, or false if there are no more elements.
     */
    public function previous();

    /**
     * Fetch a key from an array.
     *
     * @return mixed The key function simply returns the key of the array element
     * that's currently being pointed to by the internal pointer. It does not move
     * the pointer in any way. If the internal pointer points beyond the end
     * of the elements list or the array is empty, key returns null.
     */
    public function key();

    /**
     * Returns the current element in an array.
     *
     * @return mixed The current function simply returns the value of the array element
     * that's currently being pointed to by the internal pointer. It does not move
     * the pointer in any way. If the internal pointer points beyond the end
     * of the elements list or the array is empty, current returns false.
     */
    public function current();

    /**
     * Returns the current key and value pair from an array and advance the array cursor.
     *
     * @return array The current key and value pair from the array array.
     * This pair is returned in a four-element array, with the keys 0, 1, key, and value.
     * Elements 0 and key contain the key name of the array element, and 1 and value contain the data.
     * If the internal pointer for the array points past the end of the array contents, each returns false.
     */
    public function each();
}
