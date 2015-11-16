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
     * @param mixed $element The pushed element
     * @param mixed $_ [optional] Multiple arguments allowed
     *
     * @return $this The same instance with pushed elements to the end of array
     */

    public function push($element, $_ = null);
    /**
     * Shifts a specified value off the beginning of array.
     *
     * @return mixed The shifted element
     */
    public function shift();

    /**
     * Prepends one or more values to the beginning of array at once.
     *
     * @param mixed $element The element for prepend
     * @param mixed $_ [optional] Multiple arguments allowed
     *
     * @return $this The same instance with prepended elements to the beginning of array
     */
    public function unshift($element, $_ = null);
}
