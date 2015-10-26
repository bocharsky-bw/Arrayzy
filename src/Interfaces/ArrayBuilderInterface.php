<?php

namespace Arrayzy\Interfaces;

use Arrayzy\ArrayImitator;

/**
 * An interface for array builder.
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 */
interface ArrayBuilderInterface
{
    /**
     * Build an ArrayImitator instance.
     *
     * @return ArrayImitator
     */
    public function build();

    /**
     * Converts instance to a native PHP array.
     *
     * @return array The native PHP array
     */
    public function toArray();
}
