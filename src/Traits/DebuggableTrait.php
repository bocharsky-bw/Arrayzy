<?php

namespace Arrayzy\Traits;

/**
 * Class DebuggableTrait
 */
trait DebuggableTrait
{
    /**
     * Output/return printed array for debug
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
     * Export array for using in PHP scripts
     *
     * @param bool $return Whether return or output directly
     *
     * @return $this|string
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
