<?php

namespace Arrayzy\Traits;

use Closure;

/**
 * Class SortableTrait
 */
trait SortableTrait
{
    /**
     * Sort array by values
     *
     * @param int $order The order direction:
     * <ul>
     * <li>SORT_ASC</li>
     * <li>SORT_DESC</li>
     * </ul>
     * @param int $strategy The order behavior:
     * <ul>
     * <li>SORT_REGULAR</li>
     * <li>SORT_NUMERIC</li>
     * <li>SORT_STRING</li>
     * <li>SORT_LOCALE_STRING</li>
     * <li>SORT_NATURAL</li>
     * <li>SORT_FLAG_CASE</li>
     * </ul>
     * @param bool $preserveKeys Maintain index association
     * @link http://php.net/manual/en/function.sort.php
     *
     * @return static The instance with sorted elements
     */
    abstract public function sort($order = SORT_ASC, $strategy = SORT_REGULAR, $preserveKeys = false);

    /**
     * Sort array by keys
     *
     * @param int $order The order direction:
     * <ul>
     * <li>SORT_ASC</li>
     * <li>SORT_DESC</li>
     * </ul>
     * @param int $strategy The order behavior:
     * <ul>
     * <li>SORT_REGULAR</li>
     * <li>SORT_NUMERIC</li>
     * <li>SORT_STRING</li>
     * <li>SORT_LOCALE_STRING</li>
     * <li>SORT_NATURAL</li>
     * <li>SORT_FLAG_CASE</li>
     * </ul>
     * @link http://php.net/manual/en/function.sort.php
     *
     * @return static The instance with sorted elements
     */
    abstract public function sortKeys($order = SORT_ASC, $strategy = SORT_REGULAR);

    /**
     * Sort the array elements with a user-defined comparison function and maintain index association
     *
     * @param callable $callable
     *
     * @return static The instance with custom sorted elements
     */
    abstract public function customSort(Closure $callable);

    /**
     * Sort the array keys with a user-defined comparison function and maintain index association
     *
     * @param callable $callable
     *
     * @return static The new instance with custom sorted elements
     */
    abstract public function customSortKeys(Closure $callable);
}
