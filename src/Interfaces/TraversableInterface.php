<?php

namespace Arrayzy\Interfaces;

use Traversable;

/**
 * Interface TraversableInterface
 */
interface TraversableInterface extends Traversable
{
    /**
     * Set the internal pointer of an array to its first element
     *
     * @link http://php.net/manual/en/function.reset.php
     *
     * @return mixed
     */
    public function first();

    /**
     * Set the internal pointer of an array to its last element
     *
     * @link http://php.net/manual/en/function.end.php
     *
     * @return mixed
     */
    public function last();

    /**
     * Advance the internal array pointer of an array
     *
     * @link http://php.net/manual/en/function.next.php
     *
     * @return mixed
     */
    public function next();

    /**
     * Rewind the internal array pointer
     *
     * @link http://php.net/manual/en/function.prev.php
     *
     * @return mixed
     */
    public function previous();

    /**
     * Fetch a key from an array
     *
     * @link http://php.net/manual/en/function.key.php
     *
     * @return mixed
     */
    public function key();

    /**
     * Return the current element in an array
     *
     * @link http://php.net/manual/en/function.current.php
     *
     * @return mixed
     */
    public function current();

    /**
     * Return the current key and value pair from an array and advance the array cursor
     *
     * @link http://php.net/manual/en/function.each.php
     *
     * @return array
     */
    public function each();
}