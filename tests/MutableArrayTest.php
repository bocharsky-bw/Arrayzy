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
