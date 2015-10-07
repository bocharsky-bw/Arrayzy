<?php

namespace Arrayzy\Interfaces;

/**
 * An interface with helpful array modification methods.
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 */
interface ModifiableInterface
{
    /**
     * Shifts a specified value off the beginning of array.
     *
     * @return mixed The shifted element
     */
    public function shift();

    /**
     * Prepends a new value to the beginning of array.
     *
     * @param mixed $element The element for prepend
     *
     * @return $this The same instance with prepended element to the beginning of array
     */
    public function unshift($element);

    /**
     * Pop a specified value off the end of array.
     *
     * @return mixed The popped element
     */
    public function pop();

    /**
     * Push value onto the end of array.
     *
     * @param mixed $element The pushed element
     *
     * @return $this The same instance with pushed element to the end of array
     */
    public function push($element);
}
