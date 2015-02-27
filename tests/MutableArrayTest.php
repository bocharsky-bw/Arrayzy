<?php

require_once __DIR__ . '/../src/MutableArray.php';

use Arrayzy\MutableArray;

/**
 * Class MutableArrayTest
 */
class MutableArrayTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider simpleArrayProvider
     */
    public function testConstruct(array $array)
    {
        $ma = new MutableArray($array);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testCreate(array $array)
    {
        $ma = MutableArray::create($array);

        $this->assertTrue($array === $ma->toArray());
    }

    public function testCreateWithRange()
    {
        $ma1 = MutableArray::createWithRange(2, 7);
        $array1 = range(2, 7);
        $ma2 = MutableArray::createWithRange('d', 'h');
        $array2 = range('d', 'h');
        $ma3 = MutableArray::createWithRange(22, 11, 2);
        $array3 = range(22, 11, 2);
        $ma4 = MutableArray::createWithRange('y', 'k', 2);
        $array4 = range('y', 'k', 2);

        $this->assertTrue($array1 === $ma1->toArray());
        $this->assertTrue($array2 === $ma2->toArray());
        $this->assertTrue($array3 === $ma3->toArray());
        $this->assertTrue($array4 === $ma4->toArray());
    }
    /**
     * @dataProvider simpleArrayProvider
     * @depends testCreate
     */
    public function testCreateFromObject(array $array)
    {
        $ma1 = MutableArray::create($array);
        $ma2 = MutableArray::createFromObject($ma1);

        $this->assertTrue($ma1->toArray() === $ma2->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testCreateFromJson(array $array)
    {
        $json = json_encode($array);
        $ma = MutableArray::createFromJson($json);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider stringWithSeparatorProvider
     */
    public function testCreateFromString($string, $separator)
    {
        $array = explode($separator, $string);
        $ma = MutableArray::createFromString($string, $separator);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testToJson(array $array)
    {
        $json = json_encode($array);
        $ma = new MutableArray($array);

        $this->assertTrue($json === $ma->toJson());
    }

    /**
     * @dataProvider stringWithSeparatorProvider
     */
    public function testToString($string, $separator)
    {
        $array = explode($separator, $string);
        $ma = new MutableArray($array);

        $this->assertTrue($string === $ma->toString($separator));
        $this->assertTrue(implode('', $array) === (string)$ma);
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testCreateClone(array $array)
    {
        $ma = new MutableArray($array);
        $clonedMa = $ma->createClone();

        $this->assertTrue($clonedMa  == $ma);
        $this->assertTrue($clonedMa !== $ma);
        $this->assertTrue($clonedMa->toArray() === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testFlip(array $array)
    {
        $flippedArray = array_flip($array);
        $ma = new MutableArray($array);
        $ma->flip();

        $this->assertTrue($flippedArray === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testReverse(array $array)
    {
        $reversedArray = array_reverse($array);
        $ma = new MutableArray($array);
        $ma->reverse();

        $this->assertTrue($reversedArray === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testSlice(array $array)
    {
        $slicedArray = array_slice($array, 1, 1);
        $ma = new MutableArray($array);
        $ma->slice(1, 1);

        $this->assertTrue($slicedArray === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testChunk(array $array)
    {
        $chunkArray = array_chunk($array, 2);
        $ma = new MutableArray($array);
        $ma->chunk(2);

        $this->assertTrue($chunkArray === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testUnique(array $array)
    {
        $uniqueArray = array_unique($array);
        $ma = new MutableArray($array);
        $ma->unique();

        $this->assertTrue($uniqueArray === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testMerge(array $array)
    {
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];
        $mergedArray = array_merge($array, $secondArray);
        $ma = new MutableArray($array);
        $ma->merge($secondArray);

        $this->assertTrue($mergedArray === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testMergeRecursively(array $array)
    {
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];
        $mergedArray = array_merge_recursive($array, $secondArray);
        $ma = new MutableArray($array);
        $ma->merge($secondArray, true);

        $this->assertTrue($mergedArray === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testReplace(array $array)
    {
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];
        $replacedArray = array_replace($array, $secondArray);
        $ma = new MutableArray($array);
        $ma->replace($secondArray);

        $this->assertTrue($replacedArray === $ma->toArray());
    }


    /**
     * @dataProvider simpleArrayProvider
     */
    public function testReplaceRecursively(array $array)
    {
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];
        $replacedArray = array_replace_recursive($array, $secondArray);
        $ma = new MutableArray($array);
        $ma->replace($secondArray, true);

        $this->assertTrue($replacedArray === $ma->toArray());
    }

    public function testCombine()
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
        $combinedArray = array_combine($firstArray, $secondArray);
        $ma = new MutableArray($firstArray);
        $ma->combine($secondArray);

        $this->assertTrue($combinedArray === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testDiff(array $array)
    {
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];
        $arrayDiff = array_diff($array, $secondArray);
        $ma = new MutableArray($array);
        $ma->diff($secondArray);

        $this->assertTrue($arrayDiff === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testContainsKey(array $array)
    {
        $key = 2;
        $ma = new MutableArray($array);
        $containsKey = array_key_exists($key, $array);

        $this->assertTrue($containsKey === $ma->containsKey($key));
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testContains(array $array)
    {
        $element = 2;
        $ma = new MutableArray($array);
        $contains = in_array($element, $array, true);

        $this->assertTrue($contains === $ma->contains($element));
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testIndexOf(array $array)
    {
        $element = 2;
        $ma = new MutableArray($array);
        $key = array_search($element, $array, true);

        $this->assertTrue($key === $ma->indexOf($element));
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testMap(array $array)
    {
        $callable = function($value){
            return str_repeat($value, 2);
        };
        $mappedArray = array_map($callable, $array);
        $ma = new MutableArray($array);
        $ma->map($callable);

        $this->assertTrue($mappedArray === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testFilter(array $array)
    {
        $callable = function($value){
            return 2 !== $value;
        };
        $filteredArray = array_filter($array, $callable);
        $ma = new MutableArray($array);
        $ma->filter($callable);

        $this->assertTrue($filteredArray === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testWalk(array $array)
    {
        $callable = function(&$value, $key){
            $value = $key;
        };
        $ma = new MutableArray($array);
        $ma->walk($callable);
        array_walk($array, $callable);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testWalkRecursively(array $array)
    {
        $callable = function(&$value, $key){
            $value = $key;
        };
        $ma = new MutableArray($array);
        $ma->walk($callable, true);
        array_walk_recursive($array, $callable);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testCustomSort(array $array)
    {
        $callable = function($a, $b) {
            if ($a == $b) {
                return 0;
            }

            return ($a < $b) ? -1 : 1;
        };
        $ma = new MutableArray($array);
        $ma->customSort($callable, true);
        usort($array, $callable);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testCustomSortKeys(array $array)
    {
        $callable = function($a, $b) {
            if ($a == $b) {
                return 0;
            }

            return ($a > $b) ? -1 : 1;
        };
        $ma = new MutableArray($array);
        $ma->customSortKeys($callable, true);
        uksort($array, $callable);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testReduce(array $array)
    {
        $callable = function($carry, $item){
            $carry .= '-' . $item;

            return $carry;
        };
        $reducedArray = array_reduce($array, $callable, 'array');
        $ma = new MutableArray($array);

        $this->assertTrue($reducedArray === $ma->reduce($callable, 'array'));
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testShift(array $array)
    {
        $ma = new MutableArray($array);
        $shiftedValue = $ma->shift();
        $shiftedArrayValue = array_shift($array);

        $this->assertTrue($array === $ma->toArray());
        $this->assertTrue($shiftedArrayValue === $shiftedValue);
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testUnshift(array $array)
    {
        $newElement = 5;
        $ma = new MutableArray($array);
        $ma->unshift($newElement);
        array_unshift($array, $newElement);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testPop(array $array)
    {
        $ma = new MutableArray($array);
        $poppedValue = $ma->pop();
        $poppedArrayValue = array_pop($array);

        $this->assertTrue($array === $ma->toArray());
        $this->assertTrue($poppedArrayValue === $poppedValue);
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testPush(array $array)
    {
        $newElement = 5;
        $ma = new MutableArray($array);
        $ma->push($newElement);
        array_push($array, $newElement);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testPad(array $array)
    {
        $ma = new MutableArray($array);
        $ma->pad(10, 5);
        $array = array_pad($array, 10, 5);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testGetKeys(array $array)
    {
        $ma = new MutableArray($array);
        $keys = array_keys($array);

        $this->assertTrue($keys === $ma->getKeys());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testGetValues(array $array)
    {
        $ma = new MutableArray($array);
        $values = array_values($array);

        $this->assertTrue($values === $ma->getValues());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testReindex(array $array)
    {
        $ma = new MutableArray($array);
        $ma->reindex();
        $values = array_values($array);

        $this->assertTrue($values === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testGetRandom(array $array)
    {
        if (0 === count($array)) {
            return;
        }

        $ma = new MutableArray($array);
        $value = array_rand($array, 1);
        $this->assertTrue(null !== $value and null !== $ma->getRandom());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testShuffle(array $array)
    {
        $ma = new MutableArray($array);
        $ma->shuffle();
        shuffle($array);

        $this->assertTrue(count($array) === count($ma->toArray()));
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testSortAscWithPreserveKeys(array $array)
    {
        $ma = new MutableArray($array);
        $ma->sort(SORT_ASC, SORT_REGULAR, true);
        asort($array, SORT_REGULAR);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testSortAscWithoutPreserveKeys(array $array)
    {
        $ma = new MutableArray($array);
        $ma->sort(SORT_ASC, SORT_REGULAR, false);
        sort($array, SORT_REGULAR);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testSortDescWithPreserveKeys(array $array)
    {
        $ma = new MutableArray($array);
        $ma->sort(SORT_DESC, SORT_REGULAR, true);
        arsort($array, SORT_REGULAR);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testSortDescWithoutPreserveKeys(array $array)
    {
        $ma = new MutableArray($array);
        $ma->sort(SORT_DESC, SORT_REGULAR, false);
        rsort($array, SORT_REGULAR);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testSortKeysAsc(array $array)
    {
        $ma = new MutableArray($array);
        $ma->sortKeys(SORT_ASC, SORT_REGULAR);
        ksort($array, SORT_REGULAR);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testSortKeysDesc(array $array)
    {
        $ma = new MutableArray($array);
        $ma->sortKeys(SORT_DESC, SORT_REGULAR);
        krsort($array, SORT_REGULAR);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testIsEmpty(array $array)
    {
        $isEmpty = ! $array;
        $ma = new MutableArray($array);

        $this->assertTrue($isEmpty === $ma->isEmpty());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testClear(array $array)
    {
        $ma = new MutableArray($array);
        $ma->clear();

        $this->assertTrue([] === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testCount(array $array)
    {
        $ma = new MutableArray($array);
        $count = count($array);

        $this->assertTrue($count === $ma->count());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testFirst(array $array)
    {
        $ma = new MutableArray($array);
        $first = reset($array);

        $this->assertTrue($first === $ma->first());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testLast(array $array)
    {
        $ma = new MutableArray($array);
        $last = end($array);

        $this->assertTrue($last === $ma->last());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testNext(array $array)
    {
        $ma = new MutableArray($array);
        $next = next($array);

        $this->assertTrue($next === $ma->next());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testPrevious(array $array)
    {
        $ma = new MutableArray($array);
        $prev = prev($array);

        $this->assertTrue($prev === $ma->previous());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testKey(array $array)
    {
        $ma = new MutableArray($array);
        $key = key($array);

        $this->assertTrue($key === $ma->key());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testCurrent(array $array)
    {
        $ma = new MutableArray($array);
        $current = current($array);

        $this->assertTrue($current === $ma->current());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testEach(array $array)
    {
        $ma = new MutableArray($array);
        $each = each($array);

        $this->assertTrue($each === $ma->each());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testOffsetExists(array $array)
    {
        $ma = new MutableArray($array);
        $offset = 1;
        $value = isset($array[$offset]);

        $this->assertTrue($value === $ma->offsetExists($offset));
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testOffsetGet(array $array)
    {
        $ma = new MutableArray($array);
        $offset = 1;
        $value = isset($array[$offset])
            ? $array[$offset]
            : null
        ;

        $this->assertTrue($value === $ma->offsetGet($offset));
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testOffsetSet(array $array)
    {
        $ma = new MutableArray($array);
        $offset = 1;
        $value = 'new';
        if (isset($offset)) {
            $array[$offset] = $value;
        } else {
            $array[] = $value;
        }
        $ma->offsetSet($offset, $value);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testOffsetNullSet(array $array)
    {
        $ma = new MutableArray($array);
        $offset = null;
        $value = 'new';
        if (isset($offset)) {
            $array[$offset] = $value;
        } else {
            $array[] = $value;
        }
        $ma->offsetSet($offset, $value);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testOffsetUnset(array $array)
    {
        $ma = new MutableArray($array);
        $offset = 1;
        unset($array[$offset]);
        $ma->offsetUnset($offset);

        $this->assertTrue($array === $ma->toArray());
        $this->assertFalse(isset($array[$offset]));
        $this->assertFalse($ma->offsetExists($offset));
    }

    public function testGetIterator()
    {
        $ma = new MutableArray();

        $this->assertTrue($ma->getIterator() instanceof ArrayIterator);
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testExportReturn(array $array)
    {
        $ma = new MutableArray($array);
        $exported = var_export($array, true);

        $this->assertTrue($exported === $ma->export(true));
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testDebugReturn(array $array)
    {
        $ma = new MutableArray($array);
        $printed = print_r($array, true);

        $this->assertTrue($printed === $ma->debug(true));
    }

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
