<?php

namespace Arrayzy\Interfaces;

/**
 * An interface with helpful array sorting methods.
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 */
interface SortableInterface
{
    /**
     * Sorts the array elements with a user-defined comparison function and maintain index association.
     *
     * @param callable $func
     *
     * @return SortableInterface The instance with custom sorted elements
     */
    public function customSort(callable $func);

    /**
     * Sorts the array keys with a user-defined comparison function and maintain index association.
     *
     * @param callable $func
     *
     * @return SortableInterface The instance with custom sorted elements
     */
    public function customSortKeys(callable $func);

    /**
     * Sorts array by values.
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
     *
     * @return SortableInterface The instance with sorted elements
     */
    public function sort($order = SORT_ASC, $strategy = SORT_REGULAR, $preserveKeys = false);

    /**
     * Sorts array by keys.
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
     *
     * @return SortableInterface The instance with sorted elements
     */
    public function sortKeys($order = SORT_ASC, $strategy = SORT_REGULAR);
}
