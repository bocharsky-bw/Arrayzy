<?php

namespace Arrayzy\Traits;

/**
 * Class ConvertibleTrait
 */
trait ConvertibleTrait
{
    /**
     * Converting array to a string with default separator
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Convert instance to PHP array
     *
     * @return array The PHP array
     */
    public function toArray()
    {
        return $this->elements;
    }

    /**
     * Implode array to string with specified separator
     *
     * @param string $separator Element's separator
     *
     * @return string The string representation of array
     */
    public function toString($separator = self::DEFAULT_SEPARATOR)
    {
        return implode($separator, $this->elements);
    }

    /**
     * Encode array to JSON string
     *
     * @param int $options Bitmask
     * @param int $depth Set the maximum depth. Must be greater than zero
     *
     * @return string The JSON string representation of array
     */
    public function toJson($options = 0, $depth = 512)
    {
        if (version_compare(PHP_VERSION, '5.5.0', '>=')) {
            return json_encode($this->elements, $options, $depth);
        }

        return json_encode($this->elements, $options);
    }
}
