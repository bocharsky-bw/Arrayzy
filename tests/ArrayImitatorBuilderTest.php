<?php

use Arrayzy\ArrayImitator as A;
use Arrayzy\ArrayImitatorBuilder as B;

/**
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 */
class ArrayImitatorBuilderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testConstruct(array $array)
    {
        $builder = new B($array);

        $this->assertSame($array, $builder->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testBuild(array $array)
    {
        $builder = new B($array);
        $arrayzy = new A($array);

        $this->assertInstanceOf('Arrayzy\ArrayImitator', $builder->build());
        $this->assertEquals($arrayzy, $builder->build());
        $this->assertSame($array, $builder->toArray());
        $this->assertSame($array, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testToArray(array $array)
    {
        $builder = new B($array);

        $this->assertSame($array, $builder->toArray());
    }

    // The static method list order by ASC

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testStaticCreate(array $array)
    {
        $arrayzy = B::create($array)->build();

        $this->assertSame($array, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testStaticCreateFromJson(array $array)
    {
        $json = json_encode($array);

        $arrayzy = B::createFromJson($json)->build();

        $this->assertSame($array, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testStaticCreateFromObject(array $array)
    {
        $arrayAccess = new A($array);

        $arrayzy = B::createFromObject($arrayAccess)->build();

        $this->assertSame($array, $arrayzy->toArray());
    }

    /**
     * @dataProvider stringWithSeparatorProvider
     *
     * @param string $string
     * @param string $separator
     */
    public function testStaticCreateFromString($string, $separator)
    {
        $array = explode($separator, $string);

        $arrayzy = B::createFromString($string, $separator)->build();

        $this->assertSame($array, $arrayzy->toArray());
    }

    public function testStaticCreateWithRange()
    {
        $arrayzy1 = B::createWithRange(2, 7)->build();
        $array1 = range(2, 7);
        $arrayzy2 = B::createWithRange('d', 'h')->build();
        $array2 = range('d', 'h');
        $arrayzy3 = B::createWithRange(22, 11, 2)->build();
        $array3 = range(22, 11, 2);
        $arrayzy4 = B::createWithRange('y', 'k', 2)->build();
        $array4 = range('y', 'k', 2);

        $this->assertSame($array1, $arrayzy1->toArray());
        $this->assertSame($array2, $arrayzy2->toArray());
        $this->assertSame($array3, $arrayzy3->toArray());
        $this->assertSame($array4, $arrayzy4->toArray());
    }

    // The method list order by ASC

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testChunk(array $array)
    {
        $arrayzy = B::create($array)->chunk(2)->build();
        $resultArray = array_chunk($array, 2);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testClear(array $array)
    {
        $arrayzy = B::create($array)->clear()->build();

        $this->assertSame([], $arrayzy->toArray());
    }

    public function testCombineTo()
    {
        $firstArray = [
            1 => 'one',
            2 => 'two',
            3 => 'three',
        ];
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];

        $arrayzy = B::create($firstArray)->combineTo($secondArray)->build();
        $resultArray = array_combine($secondArray, $firstArray);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    public function testCombineWith()
    {
        $firstArray = [
            1 => 'one',
            2 => 'two',
            3 => 'three',
        ];
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];

        $arrayzy = B::create($firstArray)->combineWith($secondArray)->build();
        $resultArray = array_combine($firstArray, $secondArray);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testCustomSort(array $array)
    {
        $callable = function($a, $b) {
            if ($a == $b) {
                return 0;
            }

            return ($a < $b) ? -1 : 1;
        };

        $arrayzy = B::create($array)->customSort($callable)->build();
        usort($array, $callable);

        $this->assertSame($array, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testCustomSortKeys(array $array)
    {
        $callable = function($a, $b) {
            if ($a == $b) {
                return 0;
            }

            return ($a > $b) ? -1 : 1;
        };

        $arrayzy = B::create($array)->customSortKeys($callable)->build();
        uksort($array, $callable);

        $this->assertSame($array, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testDiffWith(array $array)
    {
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];

        $arrayzy = B::create($array)->diffWith($secondArray)->build();
        $resultArray = array_diff($array, $secondArray);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testFilter(array $array)
    {
        $callable = function($value){
            return 2 !== $value;
        };

        $arrayzy = B::create($array)->filter($callable)->build();
        $resultArray = array_filter($array, $callable);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testFlip(array $array)
    {
        $arrayzy = B::create($array)->flip()->build();
        $resultArray = array_flip($array);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testMap(array $array)
    {
        $callable = function($value){
            return str_repeat($value, 2);
        };

        $arrayzy = B::create($array)->map($callable)->build();
        $resultArray = array_map($callable, $array);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testMergeTo(array $array)
    {
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];

        $arrayzy = B::create($array)->mergeTo($secondArray)->build();
        $resultArray = array_merge($secondArray, $array);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testMergeToRecursively(array $array)
    {
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];

        $arrayzy = B::create($array)->mergeTo($secondArray, true)->build();
        $resultArray = array_merge_recursive($secondArray, $array);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testMergeWith(array $array)
    {
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];

        $arrayzy = B::create($array)->mergeWith($secondArray)->build();
        $resultArray = array_merge($array, $secondArray);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testMergeWithRecursively(array $array)
    {
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];

        $arrayzy = B::create($array)->mergeWith($secondArray, true)->build();
        $resultArray = array_merge_recursive($array, $secondArray);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testPad(array $array)
    {
        $arrayzy = B::create($array)->pad(10, 5)->build();
        $resultArray = array_pad($array, 10, 5);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testPop(array $array)
    {
        if (1 > count($array)) {
            return;
        }

        $builder = B::create($array);
        $poppedValue = $builder->pop();
        $resultArray = $array;
        $poppedArrayValue = array_pop($resultArray);

        $this->assertSame($poppedArrayValue, $poppedValue);
        $this->assertSame($resultArray, $builder->build()->toArray());
        $this->assertNotSame($array, $builder->build()->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testPush(array $array)
    {
        $newElement1 = 5;
        $newElement2 = 10;

        $arrayzy = B::create($array)->push($newElement1, $newElement2)->build();
        $resultArray = $array;
        array_push($resultArray, $newElement1, $newElement2);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testReindex(array $array)
    {
        $arrayzy = B::create($array)->reindex()->build();
        $resultArray = array_values($array);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testReplaceIn(array $array)
    {
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];

        $arrayzy = B::create($array)->replaceIn($secondArray)->build();
        $resultArray = array_replace($secondArray, $array);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testReplaceInRecursively(array $array)
    {
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];

        $arrayzy = B::create($array)->replaceIn($secondArray, true)->build();
        $resultArray = array_replace_recursive($secondArray, $array);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testReplaceWith(array $array)
    {
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];

        $arrayzy = B::create($array)->replaceWith($secondArray)->build();
        $resultArray = array_replace($array, $secondArray);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testReplaceWithRecursively(array $array)
    {
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];

        $arrayzy = B::create($array)->replaceWith($secondArray, true)->build();
        $resultArray = array_replace_recursive($array, $secondArray);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testReverse(array $array)
    {
        $arrayzy = B::create($array)->reverse()->build();
        $resultArray = array_reverse($array);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testShift(array $array)
    {
        if (1 > count($array)) {
            return;
        }

        $builder = B::create($array);
        $shiftedValue = $builder->shift();
        $resultArray = $array;
        $shiftedArrayValue = array_shift($resultArray);

        $this->assertSame($shiftedArrayValue, $shiftedValue);
        $this->assertSame($resultArray, $builder->build()->toArray());
        $this->assertNotSame($array, $builder->build()->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testShuffle(array $array)
    {
        $arrayzy = B::create($array)->shuffle()->build();
        shuffle($array);

        $this->assertSameSize($array, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testSlice(array $array)
    {
        $arrayzy = B::create($array)->slice(1, 1)->build();
        $resultArray = array_slice($array, 1, 1);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testSortAscWithoutPreserveKeys(array $array)
    {
        $arrayzy = B::create($array)->sort(SORT_ASC, SORT_REGULAR, false)->build();
        $resultArray = $array;
        sort($resultArray, SORT_REGULAR);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testSortAscWithPreserveKeys(array $array)
    {
        $arrayzy = B::create($array)->sort(SORT_ASC, SORT_REGULAR, true)->build();
        $resultArray = $array;
        asort($resultArray, SORT_REGULAR);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testSortDescWithoutPreserveKeys(array $array)
    {
        $arrayzy = B::create($array)->sort(SORT_DESC, SORT_REGULAR, false)->build();
        $resultArray = $array;
        rsort($resultArray, SORT_REGULAR);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testSortDescWithPreserveKeys(array $array)
    {
        $arrayzy = B::create($array)->sort(SORT_DESC, SORT_REGULAR, true)->build();
        $resultArray = $array;
        arsort($resultArray, SORT_REGULAR);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testSortKeysAsc(array $array)
    {
        $arrayzy = B::create($array)->sortKeys(SORT_ASC, SORT_REGULAR)->build();
        $resultArray = $array;
        ksort($resultArray, SORT_REGULAR);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testSortKeysDesc(array $array)
    {
        $arrayzy = B::create($array)->sortKeys(SORT_DESC, SORT_REGULAR)->build();
        $resultArray = $array;
        krsort($resultArray, SORT_REGULAR);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testUnique(array $array)
    {
        $arrayzy = B::create($array)->unique()->build();
        $resultArray = array_unique($array);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testUnshift(array $array)
    {
        $newElement1 = 5;
        $newElement2 = 10;

        $arrayzy = B::create($array)->unshift($newElement1, $newElement2)->build();
        $resultArray = $array;
        array_unshift($resultArray, $newElement1, $newElement2);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testWalk(array $array)
    {
        $callable = function(&$value, $key){
            $value = $key;
        };

        $arrayzy = B::create($array)->walk($callable)->build();
        $resultArray = $array;
        array_walk($resultArray, $callable);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testWalkRecursively(array $array)
    {
        $callable = function(&$value, $key){
            $value = $key;
        };

        $arrayzy = B::create($array)->walk($callable, true)->build();
        $resultArray = $array;
        array_walk_recursive($resultArray, $callable);

        $this->assertSame($resultArray, $arrayzy->toArray());
    }

    /**
     * @return array
     */
    public function simpleArrayProvider()
    {
        return [
            'empty_array' => [
                [],
            ],
            'indexed_array' => [
                [
                    1 => 'one',
                    2 => 'two',
                    3 => 'three',
                ],
            ],
            'assoc_array' => [
                [
                    'one' => 1,
                    'two' => 2,
                    'three' => 3,
                ],
            ],
            'mixed_array' => [
                [
                    1 => 'one',
                    'two' => 2,
                    3 => 'three',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
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
