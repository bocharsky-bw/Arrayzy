<?php

namespace Arrayzy\Interfaces;

use Arrayzy\AbstractArray;
use Closure;

/**
 * Class SortableInterface
 */
interface SortableInterface
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
     * @return SortableInterface The instance with sorted elements
     */
    public function sort($order = SORT_ASC, $strategy = SORT_REGULAR, $preserveKeys = false);

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
     * @return SortableInterface The instance with sorted elements
     */
    public function sortKeys($order = SORT_ASC, $strategy = SORT_REGULAR);

    /**
     * Sort the array elements with a user-defined comparison function and maintain index association
     *
     * @param Closure $func
     *
     * @return SortableInterface The instance with custom sorted elements
     */
    public function customSort(Closure $func);

    /**
     * Sort the array keys with a user-defined comparison function and maintain index association
     *
     * @param Closure $func
     *
     * @return SortableInterface The instance with custom sorted elements
     */
    public function customSortKeys(Closure $func);
}
