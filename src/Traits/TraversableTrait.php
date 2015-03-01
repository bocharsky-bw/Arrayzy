<?php

namespace Arrayzy\Traits;

/**
 * Class TraversableTrait
 */
trait TraversableTrait
{
    /**
     * Set the internal pointer of an array to its first element
     *
     * @link http://php.net/manual/en/function.reset.php
     *
     * @return mixed
     */
    public function first()
    {
        return reset($this->elements);
    }

    /**
     * Set the internal pointer of an array to its last element
     *
     * @link http://php.net/manual/en/function.end.php
     *
     * @return mixed
     */
    public function last()
    {
        return end($this->elements);
    }

    /**
     * Advance the internal array pointer of an array
     *
     * @link http://php.net/manual/en/function.next.php
     *
     * @return mixed
     */
    public function next()
    {
        return next($this->elements);
    }

    /**
     * Rewind the internal array pointer
     *
     * @link http://php.net/manual/en/function.prev.php
     *
     * @return mixed
     */
    public function previous()
    {
        return prev($this->elements);
    }

    /**
     * Fetch a key from an array
     *
     * @link http://php.net/manual/en/function.key.php
     *
     * @return mixed
     */
    public function key()
    {
        return key($this->elements);
    }

    /**
     * Return the current element in an array
     *
     * @link http://php.net/manual/en/function.current.php
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->elements);
    }

    /**
     * Return the current key and value pair from an array and advance the array cursor
     *
     * @link http://php.net/manual/en/function.current.php
     *
     * @return array
     */
    public function each()
    {
        return each($this->elements);
    }
}
