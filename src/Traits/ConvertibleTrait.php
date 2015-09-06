<?php

namespace Arrayzy\Traits;

use Arrayzy\AbstractArray;

/**
 * Trait with helpful convertible methods.
 *
 * @property array $elements
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
     * Implode array to readable string with specified separator
     *
     * @param string $separator Element's separator
     * @param string $conjunction Last element's conjunction
     *
     * @return string The string representation of array
     */
    public function toReadableString($separator = AbstractArray::DEFAULT_SEPARATOR, $conjunction = ' and ')
    {
        $elements = $this->elements;
        $lastElement = array_pop($elements);

        $string = implode($separator, $elements) . (count($elements) ? $conjunction : '') . $lastElement;
        unset($elements, $lastElement);

        return $string;
    }

    /**
     * Implode array to string with specified separator
     *
     * @param string $separator Element's separator
     *
     * @return string The string representation of array
     */
    public function toString($separator = AbstractArray::DEFAULT_SEPARATOR)
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
