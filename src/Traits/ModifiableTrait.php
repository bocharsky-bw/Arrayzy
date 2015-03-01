<?php

namespace Arrayzy\Traits;

/**
 * Class ModifiableTrait
 */
trait ModifiableTrait
{
    /**
     * Shift an value off the beginning of array
     *
     * @return mixed The shifted element
     */
    public function shift()
    {
        return array_shift($this->elements);
    }

    /**
     * Prepend a new value to the beginning of array
     *
     * @param mixed $element Element for prepend
     *
     * @return $this The same instance with prepended element to the beginning of array
     */
    public function unshift($element)
    {
        array_unshift($this->elements, $element);

        return $this;
    }

    /**
     * Pop the value off the end of array
     *
     * @return mixed The popped element
     */
    public function pop()
    {
        return array_pop($this->elements);
    }

    /**
     * Push value onto the end of array
     *
     * @param mixed $element Element for push
     *
     * @return $this The same instance with pushed element to the end of array
     */
    public function push($element)
    {
        array_push($this->elements, $element);

        return $this;
    }
}
