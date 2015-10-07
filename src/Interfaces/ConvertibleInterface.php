<?php

namespace Arrayzy\Interfaces;

use Arrayzy\AbstractArray;

/**
 * An interface with helpful array converting methods.
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 */
interface ConvertibleInterface
{
    /**
     * Converts array to a string with default separator.
     *
     * @return string The string representation of array
     */
    public function __toString();

    /**
     * Converts instance to a native PHP array.
     *
     * @return array The native PHP array
     */
    public function toArray();

    /**
     * Implodes array to a readable string with specified separator.
     *
     * @param string $separator The element's separator
     * @param string $conjunction The last element conjunction
     *
     * @return string The readable string representation of array
     */
    public function toReadableString($separator = AbstractArray::DEFAULT_SEPARATOR, $conjunction = ' and ');

    /**
     * Implodes array to a string with specified separator.
     *
     * @param string $separator The element's separator
     *
     * @return string The string representation of array
     */
    public function toString($separator = AbstractArray::DEFAULT_SEPARATOR);

    /**
     * Encodes array to a JSON string.
     *
     * @param int $options The bitmask
     * @param int $depth The maximum depth (must be greater than zero)
     *
     * @return string The JSON string representation of array
     */
    public function toJson($options = 0, $depth = 512);
}
