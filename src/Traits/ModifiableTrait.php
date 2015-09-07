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
     * Prepends a new value to the beginning of array.
     *
     * @param mixed $element The element for prepend
     *
     * @return $this The same instance with prepended element to the beginning of array
     *
     * @link http://php.net/manual/en/function.array-unshift.php
     */
    public function unshift($element)
    {
        array_unshift($this->elements, $element);

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
     * Push value onto the end of array.
     *
     * @param mixed $element The pushed element
     *
     * @return $this The same instance with pushed element to the end of array
     *
     * @link http://php.net/manual/en/function.array-push.php
     */
    public function push($element)
    {
        array_push($this->elements, $element);

        return $this;
    }
}
