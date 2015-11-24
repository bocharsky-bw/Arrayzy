<?php

namespace Arrayzy\Traits;

use Arrayzy\AbstractArray;

/**
 * Trait with helpful convertible methods.
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 *
 * @property array $elements
 */
trait ConvertibleTrait
{
    /**
     * Converts array to a string with default separator.
     *
     * @return string The string representation of array
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Converts instance to a native PHP array.
     *
     * @return array The native PHP array
     */
    public function toArray()
    {
        return $this->elements;
    }

    /**
     * Implodes array to a readable string with specified separator.
     *
     * @param string $separator The element's separator
     * @param string $conjunction The last element conjunction
     *
     * @return string The readable string representation of array
     *
     * @link http://php.net/manual/en/function.implode.php
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
     * Implodes array to a string with specified separator.
     *
     * @param string $separator The element's separator
     *
     * @return string The string representation of array
     *
     * @link http://php.net/manual/en/function.implode.php
     */
    public function toString($separator = AbstractArray::DEFAULT_SEPARATOR)
    {
        return implode($separator, $this->elements);
    }

    /**
     * Encodes array to a JSON string.
     *
     * @param int $options The bitmask
     * @param int $depth The maximum depth (must be greater than zero)
     *
     * @return string The JSON string representation of array
     *
     * @link http://php.net/manual/en/function.json-encode.php
     */
    public function toJson($options = 0, $depth = 512)
    {
        $params = [
            $this->elements,
            $options,
        ];

        if (version_compare(PHP_VERSION, '5.5.0', '>=')) {
            $params[] = $depth;
        }

        return call_user_func_array('json_encode', $params);
    }
}
