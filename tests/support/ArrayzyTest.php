<?php

class ArrayzyTest extends PHPUnit_Framework_TestCase
{
    public function simpleArrayProvider()
    {
        return [
            // empty array
            [
                [],
            ],
            // indexed array
            [
                [
                    1 => 'one',
                    2 => 'two',
                    3 => 'three',
                ]
            ],
            // assoc array
            [
                [
                    'one' => 1,
                    'two' => 2,
                    'three' => 3,
                ]
            ],
            // mixed array
            [
                [
                    1 => 'one',
                    'two' => 2,
                    3 => 'three',
                ]

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
