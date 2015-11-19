<?php

namespace Arrayzy\Interfaces;

/**
 * An interface with helpful array modification methods.
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 */
interface DoubleEndedQueueInterface
{
    /**
     * Pop a specified value off the end of array.
     *
     * @return mixed The popped element
     */
    public function pop();

    /**
     * Push one or more values onto the end of array at once.
     *
     * @return $this The same instance with pushed elements to the end of array
     */

    public function push(/* variadic arguments allowed */);

    /**
     * Shifts a specified value off the beginning of array.
     *
     * @return mixed The shifted element
     */
    public function shift();

    /**
     * Prepends one or more values to the beginning of array at once.
     *
     * @return $this The same instance with prepended elements to the beginning of array
     */
    public function unshift(/* variadic arguments allowed */);
}
