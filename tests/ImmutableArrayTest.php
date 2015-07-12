<?php

use Arrayzy\ImmutableArray;

/**
 * Class ImmutableArrayTest
 */
class ImmutableArrayTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider simpleArrayProvider
     */
    public function testConstruct(array $array)
    {
        $ma = new ImmutableArray($array);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testCreate(array $array)
    {
        $ma = ImmutableArray::create($array);

        $this->assertTrue($array === $ma->toArray());
    }

    public function testCreateWithRange()
    {
        $ma1 = ImmutableArray::createWithRange(2, 7);
        $array1 = range(2, 7);
        $ma2 = ImmutableArray::createWithRange('d', 'h');
        $array2 = range('d', 'h');
        $ma3 = ImmutableArray::createWithRange(22, 11, 2);
        $array3 = range(22, 11, 2);
        $ma4 = ImmutableArray::createWithRange('y', 'k', 2);
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
        $ma1 = ImmutableArray::create($array);
        $ma2 = ImmutableArray::createFromObject($ma1);

        $this->assertTrue($ma1->toArray() === $ma2->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testCreateFromJson(array $array)
    {
        $json = json_encode($array);
        $ma = ImmutableArray::createFromJson($json);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider stringWithSeparatorProvider
     */
    public function testCreateFromString($string, $separator)
    {
        $array = explode($separator, $string);
        $ma = ImmutableArray::createFromString($string, $separator);

        $this->assertTrue($array === $ma->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testToJson(array $array)
    {
        $json = json_encode($array);
        $ma = new ImmutableArray($array);

        $this->assertTrue($json === $ma->toJson());
    }

    /**
     * @dataProvider stringWithSeparatorProvider
     */
    public function testToString($string, $separator)
    {
        $array = explode($separator, $string);
        $ma = new ImmutableArray($array);

        $this->assertTrue($string === $ma->toString($separator));
        $this->assertTrue(implode('', $array) === (string)$ma);
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testCreateClone(array $array)
    {
        $ma = new ImmutableArray($array);
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
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->flip();

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($flippedArray === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testReverse(array $array)
    {
        $reversedArray = array_reverse($array);
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->reverse();

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($reversedArray === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testSlice(array $array)
    {
        $slicedArray = array_slice($array, 1, 1);
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->slice(1, 1);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($slicedArray === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testChunk(array $array)
    {
        $chunkArray = array_chunk($array, 2);
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->chunk(2);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($chunkArray === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testUnique(array $array)
    {
        $uniqueArray = array_unique($array);
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->unique();

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($uniqueArray === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testMergeWith(array $array)
    {
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];
        $mergedArray = array_merge($array, $secondArray);
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->mergeWith($secondArray);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($mergedArray === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testMergeWithRecursively(array $array)
    {
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];
        $mergedArray = array_merge_recursive($array, $secondArray);
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->mergeWith($secondArray, true);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($mergedArray === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testReplaceWith(array $array)
    {
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];
        $replacedArray = array_replace($array, $secondArray);
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->replaceWith($secondArray);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($replacedArray === $copiedMa->toArray());
    }


    /**
     * @dataProvider simpleArrayProvider
     */
    public function testReplaceWithRecursively(array $array)
    {
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];
        $replacedArray = array_replace_recursive($array, $secondArray);
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->replaceWith($secondArray, true);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($replacedArray === $copiedMa->toArray());
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
        $combinedArray = array_combine($firstArray, $secondArray);
        $ma = new ImmutableArray($firstArray);
        $copiedMa = $ma->combineWith($secondArray);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($combinedArray === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testDiffWith(array $array)
    {
        $secondArray = [
            'one' => 1,
            1 => 'one',
            2 => 2,
        ];
        $arrayDiff = array_diff($array, $secondArray);
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->diffWith($secondArray);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($arrayDiff === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testContainsKey(array $array)
    {
        $key = 2;
        $ma = new ImmutableArray($array);
        $containsKey = array_key_exists($key, $array);

        $this->assertTrue($containsKey === $ma->containsKey($key));
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testContains(array $array)
    {
        $element = 2;
        $ma = new ImmutableArray($array);
        $contains = in_array($element, $array, true);

        $this->assertTrue($contains === $ma->contains($element));
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testIndexOf(array $array)
    {
        $element = 2;
        $ma = new ImmutableArray($array);
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
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->map($callable);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($mappedArray === $copiedMa->toArray());
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
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->filter($callable);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($filteredArray === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testWalk(array $array)
    {
        $callable = function(&$value, $key){
            $value = $key;
        };
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->walk($callable);
        array_walk($array, $callable);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($array === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testWalkRecursively(array $array)
    {
        $callable = function(&$value, $key){
            $value = $key;
        };
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->walk($callable, true);
        array_walk_recursive($array, $callable);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($array === $copiedMa->toArray());
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
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->customSort($callable, true);
        usort($array, $callable);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($array === $copiedMa->toArray());
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
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->customSortKeys($callable, true);
        uksort($array, $callable);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($array === $copiedMa->toArray());
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
        $ma = new ImmutableArray($array);

        $this->assertTrue($reducedArray === $ma->reduce($callable, 'array'));
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testShift(array $array)
    {
        $ma = new ImmutableArray($array);
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
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->unshift($newElement);
        array_unshift($array, $newElement);

        $this->assertTrue($copiedMa === $ma);
        $this->assertTrue($array === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testPop(array $array)
    {
        $ma = new ImmutableArray($array);
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
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->push($newElement);
        array_push($array, $newElement);

        $this->assertTrue($copiedMa === $ma);
        $this->assertTrue($array === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testPad(array $array)
    {
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->pad(10, 5);
        $array = array_pad($array, 10, 5);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($array === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testGetKeys(array $array)
    {
        $ma = new ImmutableArray($array);
        $keys = array_keys($array);

        $this->assertTrue($keys === $ma->getKeys());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testGetValues(array $array)
    {
        $ma = new ImmutableArray($array);
        $values = array_values($array);

        $this->assertTrue($values === $ma->getValues());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testReindex(array $array)
    {
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->reindex();
        $values = array_values($array);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($values === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testGetRandomKey(array $array)
    {
        if (0 === count($array)) {
            return;
        }

        $ma = new ImmutableArray($array);
        $key = $ma->getRandomKey();
        $this->assertTrue(null !== $key);
        $this->assertTrue(array_key_exists($key, $ma->toArray()));
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testGetRandom(array $array)
    {
        if (0 === count($array)) {
            return;
        }

        $ma = new ImmutableArray($array);
        $value = $ma->getRandom();
        $this->assertTrue(null !== $value);
        $this->assertTrue(in_array($value, $ma->toArray()));
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testGetRandomKeys(array $array)
    {
        if (0 === count($array)) {
            return;
        }

        $ma = new ImmutableArray($array);
        $keys = $ma->getRandomKeys(2);
        $this->assertCount(2, $keys);
        foreach ($keys as $key) {
            $this->assertTrue(array_key_exists($key, $array));
        }
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testGetRandomValues(array $array)
    {
        if (0 === count($array)) {
            return;
        }

        $ma = new ImmutableArray($array);
        $values = $ma->getRandomValues(2);
        $this->assertCount(2, $values);
        foreach ($values as $value) {
            $this->assertTrue(in_array($value, $array));
        }
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testShuffle(array $array)
    {
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->shuffle();
        shuffle($array);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue(count($array) === count($copiedMa->toArray()));
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testSortAscWithPreserveKeys(array $array)
    {
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->sort(SORT_ASC, SORT_REGULAR, true);
        asort($array, SORT_REGULAR);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($array === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testSortAscWithoutPreserveKeys(array $array)
    {
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->sort(SORT_ASC, SORT_REGULAR, false);
        sort($array, SORT_REGULAR);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($array === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testSortDescWithPreserveKeys(array $array)
    {
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->sort(SORT_DESC, SORT_REGULAR, true);
        arsort($array, SORT_REGULAR);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($array === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testSortDescWithoutPreserveKeys(array $array)
    {
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->sort(SORT_DESC, SORT_REGULAR, false);
        rsort($array, SORT_REGULAR);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($array === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testSortKeysAsc(array $array)
    {
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->sortKeys(SORT_ASC, SORT_REGULAR);
        ksort($array, SORT_REGULAR);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($array === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testSortKeysDesc(array $array)
    {
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->sortKeys(SORT_DESC, SORT_REGULAR);
        krsort($array, SORT_REGULAR);

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue($array === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testIsEmpty(array $array)
    {
        $isEmpty = ! $array;
        $ma = new ImmutableArray($array);

        $this->assertTrue($isEmpty === $ma->isEmpty());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testClear(array $array)
    {
        $ma = new ImmutableArray($array);
        $copiedMa = $ma->clear();

        $this->assertTrue($copiedMa !== $ma);
        $this->assertTrue([] === $copiedMa->toArray());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testCount(array $array)
    {
        $ma = new ImmutableArray($array);
        $count = count($array);

        $this->assertTrue($count === $ma->count());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testFirst(array $array)
    {
        $ma = new ImmutableArray($array);
        $first = reset($array);

        $this->assertTrue($first === $ma->first());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testLast(array $array)
    {
        $ma = new ImmutableArray($array);
        $last = end($array);

        $this->assertTrue($last === $ma->last());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testNext(array $array)
    {
        $ma = new ImmutableArray($array);
        $next = next($array);

        $this->assertTrue($next === $ma->next());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testPrevious(array $array)
    {
        $ma = new ImmutableArray($array);
        $prev = prev($array);

        $this->assertTrue($prev === $ma->previous());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testKey(array $array)
    {
        $ma = new ImmutableArray($array);
        $key = key($array);

        $this->assertTrue($key === $ma->key());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testCurrent(array $array)
    {
        $ma = new ImmutableArray($array);
        $current = current($array);

        $this->assertTrue($current === $ma->current());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testEach(array $array)
    {
        $ma = new ImmutableArray($array);
        $each = each($array);

        $this->assertTrue($each === $ma->each());
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testOffsetExists(array $array)
    {
        $ma = new ImmutableArray($array);
        $offset = 1;
        $value = isset($array[$offset]);

        $this->assertTrue($value === $ma->offsetExists($offset));
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testOffsetGet(array $array)
    {
        $ma = new ImmutableArray($array);
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
        $ma = new ImmutableArray($array);
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
        $ma = new ImmutableArray($array);
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
        $ma = new ImmutableArray($array);
        $offset = 1;
        unset($array[$offset]);
        $ma->offsetUnset($offset);

        $this->assertTrue($array === $ma->toArray());
        $this->assertFalse(isset($array[$offset]));
        $this->assertFalse($ma->offsetExists($offset));
    }

    public function testGetIterator()
    {
        $ma = new ImmutableArray();

        $this->assertTrue($ma->getIterator() instanceof ArrayIterator);
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testExportReturn(array $array)
    {
        $ma = new ImmutableArray($array);
        $exported = var_export($array, true);

        $this->assertTrue($exported === $ma->export(true));
    }

    /**
     * @dataProvider simpleArrayProvider
     */
    public function testDebugReturn(array $array)
    {
        $ma = new ImmutableArray($array);
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
