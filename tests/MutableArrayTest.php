<?php

use Arrayzy\MutableArray as A;

/**
 * Class MutableArrayTest
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 */
class MutableArrayTest extends AbstractArrayTest
{
    public function setUp()
    {
        $this->arrayzyClassName = 'Arrayzy\MutableArray';
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testConstruct(array $array)
    {
        $arrayzy = new A($array);

        $this->assertSame($array, $arrayzy->toArray());
    }

    // The static method list order by ASC

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testCreate(array $array)
    {
        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->create($array);

        $this->assertImmutable($arrayzy, $resultArrayzy, $array, $array);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testCreateClone(array $array)
    {
        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->createClone();

        $this->assertImmutable($arrayzy, $resultArrayzy, $array, $array);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testCreateFromJson(array $array)
    {
        $json = json_encode($array);

        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->createFromJson($json);

        $this->assertImmutable($arrayzy, $resultArrayzy, $array, $array);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testCreateFromObject(array $array)
    {
        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->createFromObject($arrayzy);

        $this->assertImmutable($arrayzy, $resultArrayzy, $array, $array);
    }

    /**
     * @dataProvider stringWithSeparatorProvider
     *
     * @param string $string
     * @param string $separator
     */
    public function testCreateFromString($string, $separator)
    {
        $array = explode($separator, $string);

        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->createFromString($string, $separator);

        $this->assertImmutable($arrayzy, $resultArrayzy, $array, $array);
    }

    public function testCreateWithRange()
    {
        $arrayzy1 = A::createWithRange(2, 7);
        $array1 = range(2, 7);
        $arrayzy2 = A::createWithRange('d', 'h');
        $array2 = range('d', 'h');
        $arrayzy3 = A::createWithRange(22, 11, 2);
        $array3 = range(22, 11, 2);
        $arrayzy4 = A::createWithRange('y', 'k', 2);
        $array4 = range('y', 'k', 2);

        $this->assertSame($array1, $arrayzy1->toArray());
        $this->assertSame($array2, $arrayzy2->toArray());
        $this->assertSame($array3, $arrayzy3->toArray());
        $this->assertSame($array4, $arrayzy4->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testStaticCreate(array $array)
    {
        $arrayzy = new A($array);
        $resultArrayzy = A::create($array);

        $this->assertImmutable($arrayzy, $resultArrayzy, $array, $array);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testStaticCreateFromJson(array $array)
    {
        $json = json_encode($array);

        $arrayzy = A::create($array);
        $resultArrayzy = A::createFromJson($json);

        $this->assertImmutable($arrayzy, $resultArrayzy, $array, $array);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testStaticCreateFromObject(array $array)
    {
        $arrayzy = A::create($array);
        $resultArrayzy = A::createFromObject($arrayzy);

        $this->assertImmutable($arrayzy, $resultArrayzy, $array, $array);
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

        $arrayzy = A::create($array);
        $resultArrayzy = A::createFromString($string, $separator);

        $this->assertImmutable($arrayzy, $resultArrayzy, $array, $array);
    }

    // The method list order by ASC

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testChunk(array $array)
    {
        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->chunk(2);
        $resultArray = array_chunk($array, 2);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testClear(array $array)
    {
        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->clear();

        $this->assertMutable($arrayzy, $resultArrayzy, []);
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

        $arrayzy = new A($firstArray);
        $resultArrayzy = $arrayzy->combineTo($secondArray);
        $resultArray = array_combine($secondArray, $firstArray);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
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

        $arrayzy = new A($firstArray);
        $resultArrayzy = $arrayzy->combineWith($secondArray);
        $resultArray = array_combine($firstArray, $secondArray);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
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

        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->customSort($callable);
        $resultArray = $array;
        usort($resultArray, $callable);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
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

        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->customSortKeys($callable);
        $resultArray = $array;
        uksort($resultArray, $callable);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
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

        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->diffWith($secondArray);
        $resultArray = array_diff($array, $secondArray);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
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

        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->filter($callable);
        $resultArray = array_filter($array, $callable);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testFlip(array $array)
    {
        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->flip();
        $resultArray = array_flip($array);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
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

        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->map($callable);
        $resultArray = array_map($callable, $array);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
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

        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->mergeTo($secondArray);
        $resultArray = array_merge($secondArray, $array);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
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

        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->mergeTo($secondArray, true);
        $resultArray = array_merge_recursive($secondArray, $array);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
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

        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->mergeWith($secondArray);
        $resultArray = array_merge($array, $secondArray);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
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

        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->mergeWith($secondArray, true);
        $resultArray = array_merge_recursive($array, $secondArray);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testOffsetNullSet(array $array)
    {
        $offset = null;
        $value = 'new';

        $arrayzy = new A($array);
        $arrayzy->offsetSet($offset, $value);
        if (isset($offset)) {
            $array[$offset] = $value;
        } else {
            $array[] = $value;
        }

        $this->assertSame($array, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testOffsetSet(array $array)
    {
        $offset = 1;
        $value = 'new';

        $arrayzy = new A($array);
        $arrayzy->offsetSet($offset, $value);
        if (isset($offset)) {
            $array[$offset] = $value;
        } else {
            $array[] = $value;
        }

        $this->assertSame($array, $arrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testOffsetUnset(array $array)
    {
        $arrayzy = new A($array);
        $offset = 1;

        $arrayzy->offsetUnset($offset);
        unset($array[$offset]);

        $this->assertSame($array, $arrayzy->toArray());
        $this->assertFalse(isset($array[$offset]));
        $this->assertFalse($arrayzy->offsetExists($offset));
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testPad(array $array)
    {
        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->pad(10, 5);
        $resultArray = array_pad($array, 10, 5);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testPop(array $array)
    {
        $arrayzy = new A($array);
        $poppedValue = $arrayzy->pop();

        $poppedArrayValue = array_pop($array);
        $this->assertTrue($array === $arrayzy->toArray());
        $this->assertTrue($poppedArrayValue === $poppedValue);
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

        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->push($newElement1, $newElement2);

        array_push($array, $newElement1, $newElement2);
        $this->assertSame($array, $resultArrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testReindex(array $array)
    {
        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->reindex();
        $resultArray = array_values($array);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
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

        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->replaceIn($secondArray);
        $resultArray = array_replace($secondArray, $array);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
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

        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->replaceIn($secondArray, true);
        $resultArray = array_replace_recursive($secondArray, $array);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
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

        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->replaceWith($secondArray);
        $resultArray = array_replace($array, $secondArray);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
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

        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->replaceWith($secondArray, true);
        $resultArray = array_replace_recursive($array, $secondArray);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testReverse(array $array)
    {
        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->reverse();
        $resultArray = array_reverse($array);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testShift(array $array)
    {
        $arrayzy = new A($array);
        $shiftedValue = $arrayzy->shift();
        $shiftedArrayValue = array_shift($array);

        $this->assertTrue($array === $arrayzy->toArray());
        $this->assertTrue($shiftedArrayValue === $shiftedValue);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testShuffle(array $array)
    {
        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->shuffle();
        shuffle($array);

        $this->assertSame($arrayzy, $resultArrayzy);
        $this->assertSameSize($array, $resultArrayzy->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testSlice(array $array)
    {
        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->slice(1, 1);
        $resultArray = array_slice($array, 1, 1);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testSortAscWithoutPreserveKeys(array $array)
    {
        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->sort(SORT_ASC, SORT_REGULAR, false);
        $resultArray = $array;
        sort($resultArray, SORT_REGULAR);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testSortAscWithPreserveKeys(array $array)
    {
        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->sort(SORT_ASC, SORT_REGULAR, true);
        $resultArray = $array;
        asort($resultArray, SORT_REGULAR);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testSortDescWithoutPreserveKeys(array $array)
    {
        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->sort(SORT_DESC, SORT_REGULAR, false);
        $resultArray = $array;
        rsort($resultArray, SORT_REGULAR);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testSortDescWithPreserveKeys(array $array)
    {
        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->sort(SORT_DESC, SORT_REGULAR, true);
        $resultArray = $array;
        arsort($resultArray, SORT_REGULAR);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testSortKeysAsc(array $array)
    {
        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->sortKeys(SORT_ASC, SORT_REGULAR);
        $resultArray = $array;
        ksort($resultArray, SORT_REGULAR);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testSortKeysDesc(array $array)
    {
        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->sortKeys(SORT_DESC, SORT_REGULAR);
        $resultArray = $array;
        krsort($resultArray, SORT_REGULAR);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testUnique(array $array)
    {
        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->unique();
        $resultArray = array_unique($array);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
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

        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->unshift($newElement1, $newElement2);
        array_unshift($array, $newElement1, $newElement2);

        $this->assertTrue($resultArrayzy === $arrayzy);
        $this->assertTrue($array === $resultArrayzy->toArray());
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

        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->walk($callable);
        $resultArray = $array;
        array_walk($resultArray, $callable);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
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

        $arrayzy = new A($array);
        $resultArrayzy = $arrayzy->walk($callable, true);
        $resultArray = $array;
        array_walk_recursive($resultArray, $callable);

        $this->assertMutable($arrayzy, $resultArrayzy, $resultArray);
    }
}
