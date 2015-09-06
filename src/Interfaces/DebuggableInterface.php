<?php

namespace Arrayzy\Interfaces;

/**
 * Interface DebuggableInterface
 */
interface DebuggableInterface
{
    /**
     * Output/return printed array for debug
     *
     * @param bool $return Whether return or output directly
     *
     * @return $this|string
     */
    public function debug($return = false);

    /**
     * Export array for using in PHP scripts
     *
     * @param bool $return Whether return or output directly
     *
     * @return $this|string
     */
    public function export($return = false);
}