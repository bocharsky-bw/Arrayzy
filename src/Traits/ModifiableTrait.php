<?php

namespace Arrayzy\Traits;

/**
 * Trait with helpful modifiable methods.
 *
 * @property array $elements
 */
trait ModifiableTrait
{
    /**
     * Shifts a specified value off the beginning of array.
     *
     * @return mixed The shifted element
     *
     * @link http://php.net/manual/en/function.array-shift.php
     */
    public function shift()
    {
        return array_shift($this->elements);
    }

    /**
     * Prepends one or more values to the beginning of array at once.
     *
     * @param mixed $element The element for prepend
     * @param mixed $_ [optional] Multiple arguments allowed
     *
     * @return $this The same instance with prepended elements to the beginning of array
     *
     * @link http://php.net/manual/en/function.array-unshift.php
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
     * Pop a specified value off the end of array.
     *
     * @return mixed The popped element
     *
     * @link http://php.net/manual/en/function.array-pop.php
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
     * @return $this The same instance with pushed elements to the end of array
     *
     * @link http://php.net/manual/en/function.array-push.php
     */
    public function push($element, $_ = null)
    {
        if (func_num_args()) {
            $args = array_merge([&$this->elements], func_get_args());
            call_user_func_array('array_push', $args);
        }

        return $this;
    }
}
