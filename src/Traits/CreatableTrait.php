<?php

namespace Arrayzy\Traits;

use ArrayAccess;

/**
 * Class CreatableTrait
 */
trait CreatableTrait
{
    /**
     * Create a new instance
     *
     * @param array $elements
     *
     * @return static Returns created instance
     */
    public static function create(array $elements = [])
    {
        return new static($elements);
    }

    /**
     * Create a new instance from the implemented ArrayAccess instance
     *
     * @param ArrayAccess $elements Object that implements the ArrayAccess
     *
     * @return static Returns created instance
     */
    public static function createFromObject(ArrayAccess $elements)
    {
        $array = new static();

        foreach ($elements as $key => $value) {
            $array[$key] = $value;
        }

        return $array;
    }

    /**
     * Decode a JSON string to new instance
     *
     * @param string $json The json string being decoded
     * @param int $options Bitmask of JSON decode options
     * @param int $depth Specified recursion depth
     *
     * @return static Returns created instance
     */
    public static function createFromJson($json, $options = 0, $depth = 512)
    {
        return new static(json_decode($json, true, $depth, $options));
    }

    /**
     * Explode a string to new instance by specified separator
     *
     * @param string $string Converted string
     * @param string $separator Element's separator
     *
     * @return static Returns created instance
     */
    public static function createFromString($string, $separator)
    {
        return new static(explode($separator, $string));
    }


    /**
     * Create a new instance containing a range of elements
     *
     * @param mixed $low First value of the sequence
     * @param mixed $high The sequence is ended upon reaching the end value
     * @param int $step Used as the increment between elements in the sequence
     *
     * @return static Returns created instance
     */
    public static function createWithRange($low, $high, $step = 1)
    {
        return new static(range($low, $high, $step));
    }

    /**
     * Clone current instance to new instance
     *
     * @return $this Returns cloned instance
     */
    public function createClone()
    {
        return clone $this;
    }
}
