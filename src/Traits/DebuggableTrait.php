<?php

namespace Arrayzy\Traits;

/**
 * Trait with helpful methods for debugging.
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 *
 * @property array $elements
 */
trait DebuggableTrait
{
    /**
     * Outputs/returns printed array for debug.
     *
     * @param bool $return Whether return or output directly
     *
     * @return $this|string
     */
    public function debug($return = false)
    {
        if ($return) {
            return print_r($this->elements, true);
        }

        print_r($this->elements, false);

        return $this;
    }

    /**
     * Exports array for using in PHP scripts.
     *
     * @param bool $return Whether return or output directly
     *
     * @return $this|string
     *
     * @link http://php.net/manual/en/function.var-export.php
     */
    public function export($return = false)
    {
        if ($return) {
            return var_export($this->elements, true);
        }

        var_export($this->elements, false);

        return $this;
    }
}
