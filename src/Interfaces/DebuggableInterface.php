<?php

namespace Arrayzy\Interfaces;

/**
 * An interface with helpful array debugging methods.
 */
interface DebuggableInterface
{
    /**
     * Outputs/returns printed array for debug.
     *
     * @param bool $return Whether return or output directly
     *
     * @return $this|string
     */
    public function debug($return = false);

    /**
     * Exports array for using in PHP scripts.
     *
     * @param bool $return Whether return or output directly
     *
     * @return $this|string
     */
    public function export($return = false);
}
