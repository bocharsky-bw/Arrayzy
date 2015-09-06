<?php

namespace Arrayzy\Interfaces;

use Arrayzy\AbstractArray;

/**
 * Interface ConvertibleInterface
 */
interface ConvertibleInterface
{
    /**
     * Converting array to a string with default separator
     *
     * @return string
     */
    public function __toString();

    /**
     * Convert instance to PHP array
     *
     * @return array The PHP array
     */
    public function toArray();

    /**
     * Implode array to readable string with specified separator
     *
     * @param string $separator Element's separator
     * @param string $conjunction Last element's conjunction
     *
     * @return string The string representation of array
     */
    public function toReadableString($separator = AbstractArray::DEFAULT_SEPARATOR, $conjunction = ' and ');

    /**
     * Implode array to string with specified separator
     *
     * @param string $separator Element's separator
     *
     * @return string The string representation of array
     */
    public function toString($separator = AbstractArray::DEFAULT_SEPARATOR);

    /**
     * Encode array to JSON string
     *
     * @param int $options Bitmask
     * @param int $depth Set the maximum depth. Must be greater than zero
     *
     * @return string The JSON string representation of array
     */
    public function toJson($options = 0, $depth = 512);
}