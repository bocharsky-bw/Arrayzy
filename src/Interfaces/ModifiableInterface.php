<?php

namespace Arrayzy\Interfaces;

/**
 * Interface ModifiableInterface
 */
interface ModifiableInterface
{
    /**
     * Shift an value off the beginning of array
     *
     * @return mixed The shifted element
     */
    public function shift();

    /**
     * Prepend a new value to the beginning of array
     *
     * @param mixed $element Element for prepend
     *
     * @return $this The same instance with prepended element to the beginning of array
     */
    public function unshift($element);

    /**
     * Pop the value off the end of array
     *
     * @return mixed The popped element
     */
    public function pop();

    /**
     * Push value onto the end of array
     *
     * @param mixed $element Element for push
     *
     * @return $this The same instance with pushed element to the end of array
     */
    public function push($element);
}