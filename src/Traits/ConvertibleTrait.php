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
     * Convert the current array to a string with default separator.
     *
     * @return string A string representation of the current array
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Convert the current array to a native PHP array.
     *
     * @return array A native PHP array
     */
    public function toArray()
    {
        return $this->elements;
    }

    /**
     * Implode the current array to a readable string with specified separator.
     *
     * @param string $separator The element's separator
     * @param string $conjunction The last element conjunction
     *
     * @return string A readable string representation of the current array
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
     * Implode the current array to a string with specified separator.
     *
     * @param string $separator The element's separator
     *
     * @return string A string representation of the current array
     *
     * @link http://php.net/manual/en/function.implode.php
     */
    public function toString($separator = AbstractArray::DEFAULT_SEPARATOR)
    {
        return implode($separator, $this->elements);
    }

    /**
     * Encode the current array to a JSON string.
     *
     * @param int $options The bitmask
     * @param int $depth The maximum depth (must be greater than zero)
     *
     * @return string A JSON string representation of the current array
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

        // use call_user_func_array() here to fully cover this method in test
        return call_user_func_array('json_encode', $params);
    }
}
