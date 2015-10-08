<?php

/**
 * The base class for testing
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 */
abstract class AbstractArrayTest extends PHPUnit_Framework_TestCase
{
    public function simpleArrayProvider()
    {
        return [
            'empty_array' =>
            [
                [],
                'empty'
            ],
            'indexed_array' =>
            [
                [
                    1 => 'one',
                    2 => 'two',
                    3 => 'three',
                ],
                'numeric'
            ],
            'assoc_array' =>
            [
                [
                    'one' => 1,
                    'two' => 2,
                    'three' => 3,
                ],
                'assoc'
            ],
            'mixed_array' =>
            [
                [
                    1 => 'one',
                    'two' => 2,
                    3 => 'three',
                ],
                'mixed'
            ],
        ];
    }

    public function stringWithSeparatorProvider()
    {
        return [
            [
                's,t,r,i,n,g',
                ','
            ],
            [
                'He|ll|o',
                '|'
            ],
            [
                'Wo;rld',
                ';'
            ],
        ];
    }
}
