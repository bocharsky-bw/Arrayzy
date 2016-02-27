<?php

namespace Arrayzy\Traits;

/**
 * Trait with helpful double-ended queue methods.
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 *
 * @property array $elements
 */
trait DoubleEndedQueueTrait
{
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
     * @return $this The current array with pushed elements
     * to the end of array
     */
    public function push(/* variadic arguments allowed */)
    {
        if (func_num_args()) {
            $args = array_merge([&$this->elements], func_get_args());
            call_user_func_array('array_push', $args);
        }

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
     * Prepends one or more values to the beginning of array at once.
     *
     * @return $this The current array with prepended elements to the beginning of array
     */
    public function unshift(/* variadic arguments allowed */)
    {
        if (func_num_args()) {
            $args = array_merge([&$this->elements], func_get_args());
            call_user_func_array('array_unshift', $args);
        }

        return $this;
    }
}
