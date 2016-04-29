<?php

use Arrayzy\AbstractArray as A;

/**
 * The base class for testing
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 */
abstract class AbstractArrayTest extends PHPUnit_Framework_TestCase
{
    const TYPE_EMPTY = 'empty';
    const TYPE_NUMERIC = 'numeric';
    const TYPE_ASSOC = 'assoc';
    const TYPE_MIXED = 'mixed';

    /**
     * @var string
     */
    protected $arrayzyClassName;

    /**
     * @param array $array
     *
     * @return A
     */
    protected function createArrayzy(array $array = [])
    {
        return new $this->arrayzyClassName($array);
    }

    /**
     * @param A $arrayzy
     * @param A $resultArrayzy
     * @param array $array
     * @param array $resultArray
     */
    protected function assertImmutable(A $arrayzy, A $resultArrayzy, array $array, array $resultArray)
    {
        $this->assertNotSame($arrayzy, $resultArrayzy);
        $this->assertSame($array, $arrayzy->toArray());
        $this->assertSame($resultArray, $resultArrayzy->toArray());
    }

    /**
     * @param A $arrayzy
     * @param A $resultArrayzy
     * @param array $resultArray
     */
    protected function assertMutable(A $arrayzy, A $resultArrayzy, array $resultArray)
    {
        $this->assertSame($arrayzy, $resultArrayzy);
        $this->assertSame($resultArray, $arrayzy->toArray());
        $this->assertSame($resultArray, $resultArrayzy->toArray());
    }

    /**
     * @return array
     */
    public function simpleArrayProvider()
    {
        return [
            'empty_array' => [
                [],
                self::TYPE_EMPTY,
            ],
            'indexed_array' => [
                [
                    1 => 'one',
                    2 => 'two',
                    3 => 'three',
                ],
                self::TYPE_NUMERIC,
            ],
            'assoc_array' => [
                [
                    'one' => 1,
                    'two' => 2,
                    'three' => 3,
                ],
                self::TYPE_ASSOC,
            ],
            'mixed_array' => [
                [
                    1 => 'one',
                    'two' => 2,
                    3 => 'three',
                ],
                self::TYPE_MIXED,
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

    // The method list order by ASC

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testContains(array $array)
    {
        $element = 2;

        $arrayzy = $this->createArrayzy($array);
        $isContains = in_array($element, $array, true);

        $this->assertSame($isContains, $arrayzy->contains($element));
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testContainsKey(array $array)
    {
        $key = 2;

        $arrayzy = $this->createArrayzy($array);
        $isContainsKey = array_key_exists($key, $array);

        $this->assertSame($isContainsKey, $arrayzy->containsKey($key));
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testCount(array $array)
    {
        $arrayzy = $this->createArrayzy($array);
        $count = count($array);

        $this->assertSame($count, $arrayzy->count());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testCurrent(array $array)
    {
        $arrayzy = $this->createArrayzy($array);
        $current = current($array);

        $this->assertSame($current, $arrayzy->current());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testDebug(array $array)
    {
        $arrayzy = $this->createArrayzy($array);
        $printed = print_r($array, true);
        $this->assertSame($printed, $arrayzy->debug(true));

        ob_start();
        $arrayzy->debug();
        $this->assertSame($printed, ob_get_clean());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testEach(array $array)
    {
        $arrayzy = $this->createArrayzy($array);
        $each = each($array);

        $this->assertSame($each, $arrayzy->each());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     * @param string $type
     */
    public function testExcept(array $array, $type = null)
    {
        if ($type !== self::TYPE_EMPTY) {
            $arrayzy = $this->createArrayzy($array);
            $arrayzy2 = clone $arrayzy;

            $randomKeys = $arrayzy->getRandomKeys(2);

            foreach ($randomKeys as $key) {
                $arrayzy->offsetUnset($key);
            }

            $this->assertSame($arrayzy2->except($randomKeys)->toArray(), $arrayzy->toArray());
        }
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testExists(array $array)
    {
        $callable = function($key, $value) {
            return 2 === $key and 'two' === $value;
        };

        $arrayzy = $this->createArrayzy($array);
        $isExists = isset($array[2]) && 'two' === $array[2];

        $this->assertSame($isExists, $arrayzy->exists($callable));
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testExport(array $array)
    {
        $arrayzy = $this->createArrayzy($array);
        $exported = var_export($array, true);
        $this->assertSame($exported, $arrayzy->export(true));

        ob_start();
        $arrayzy->export();
        $this->assertSame($exported, ob_get_clean());
    }

    public function testFind()
    {
        $callable = function($value, $key) {
            return 'a' === $value and 2 < $key;
        };

        $a = $this->createArrayzy(['a', 'b', 'c', 'b', 'a']);
        $found = $a->find($callable);

        $this->assertSame('a', $found);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testFirst(array $array)
    {
        $arrayzy = $this->createArrayzy($array);
        $first = reset($array);

        $this->assertSame($first, $arrayzy->first());
    }

    public function testGetIterator()
    {
        $arrayzy = $this->createArrayzy();

        $this->assertInstanceOf('ArrayIterator', $arrayzy->getIterator());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testGetKeys(array $array)
    {
        $arrayzy = $this->createArrayzy($array);
        $keys = array_keys($array);

        $this->assertSame($keys, $arrayzy->getKeys());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testGetRandom(array $array)
    {
        if (0 === count($array)) {
            return;
        }

        $arrayzy = $this->createArrayzy($array);
        $value = $arrayzy->getRandom();

        $this->assertNotSame(null, $value);
        $this->assertTrue(in_array($value, $arrayzy->toArray()));
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testGetRandomKey(array $array)
    {
        if (0 === count($array)) {
            return;
        }

        $arrayzy = $this->createArrayzy($array);
        $key = $arrayzy->getRandomKey();

        $this->assertNotSame(null, $key);
        $this->assertTrue(array_key_exists($key, $arrayzy->toArray()));
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testGetRandomKeysShouldReturnArray(array $array)
    {
        if (0 === count($array)) {
            return;
        }

        $arrayzy = $this->createArrayzy($array);
        $keys = $arrayzy->getRandomKeys(count($array));

        $this->assertInternalType('array', $keys);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testGetRandomKeys(array $array)
    {
        if (2 > count($array)) {
            return;
        }

        $arrayzy = $this->createArrayzy($array);
        $keys = $arrayzy->getRandomKeys(2);

        $this->assertCount(2, $keys);
        foreach ($keys as $key) {
            $this->assertTrue(array_key_exists($key, $array));
        }
    }

    /**
     * @expectedException \RangeException
     */
    public function testGetRandomKeysRangeException()
    {
        $arrayzy = $this->createArrayzy(['a', 'b', 'c']);
        $arrayzy->getRandomKeys(4);
    }

    /**
     * @expectedException \RangeException
     */
    public function testGetRandomKeysLogicExceptionGivenZero()
    {
        $arrayzy = $this->createArrayzy(['a', 'b', 'c']);
        $arrayzy->getRandomKeys(0);
    }

    /**
     * @expectedException \RangeException
     */
    public function testGetRandomKeysLogicExceptionGivenNonInteger()
    {
        $arrayzy = $this->createArrayzy(['a', 'b', 'c']);
        $arrayzy->getRandomKeys('something');
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testGetRandomValues(array $array)
    {
        if (2 > count($array)) {
            return;
        }

        $arrayzy = $this->createArrayzy($array);
        $values = $arrayzy->getRandomValues(2);

        $this->assertCount(2, $values);
        foreach ($values as $value) {
            $this->assertTrue(in_array($value, $array));
        }
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testGetRandomValuesSingle(array $array)
    {
        if (0 === count($array)) {
            return;
        }

        $arrayzy = $this->createArrayzy($array);
        $values = $arrayzy->getRandomValues(1);

        $this->assertCount(1, $values);
        $this->assertInternalType('array', $values);
        foreach ($values as $value) {
            $this->assertTrue(in_array($value, $array));
        }
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testGetValues(array $array)
    {
        $arrayzy = $this->createArrayzy($array);
        $values = array_values($array);

        $this->assertSame($values, $arrayzy->getValues());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testIndexOf(array $array)
    {
        $element = 2;

        $arrayzy = $this->createArrayzy($array);
        $key = array_search($element, $array, true);

        $this->assertSame($key, $arrayzy->indexOf($element));
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     * @param string $type
     */
    public function testIsAssoc(array $array, $type = null)
    {
        $arrayzy = $this->createArrayzy($array);
        $isAssoc = static::TYPE_ASSOC === $type;

        $this->assertSame($isAssoc, $arrayzy->isAssoc());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testIsEmpty(array $array)
    {
        $isEmpty = ! $array;
        $arrayzy = $this->createArrayzy($array);

        $this->assertSame($isEmpty, $arrayzy->isEmpty());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     * @param string $type
     */
    public function testIsNumeric(array $array, $type = null)
    {
        $arrayzy = $this->createArrayzy($array);
        $isNumeric = static::TYPE_NUMERIC === $type;

        $this->assertSame($isNumeric, $arrayzy->isNumeric());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testKey(array $array)
    {
        $arrayzy = $this->createArrayzy($array);
        $key = key($array);

        $this->assertSame($key, $arrayzy->key());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testLast(array $array)
    {
        $arrayzy = $this->createArrayzy($array);
        $last = end($array);

        $this->assertSame($last, $arrayzy->last());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testNext(array $array)
    {
        $arrayzy = $this->createArrayzy($array);
        $next = next($array);

        $this->assertSame($next, $arrayzy->next());
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testOffsetExists(array $array)
    {
        $offset = 1;
        $isOffsetExists = isset($array[$offset]);

        $arrayzy = $this->createArrayzy($array);

        $this->assertSame($isOffsetExists, $arrayzy->offsetExists($offset));
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testOffsetGet(array $array)
    {
        $offset = 1;
        $value = isset($array[$offset])
            ? $array[$offset]
            : null
        ;

        $arrayzy = $this->createArrayzy($array);

        $this->assertSame($value, $arrayzy->offsetGet($offset));
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     * @param string $type
     */
    public function testOnly(array $array, $type = null)
    {
        if ($type !== self::TYPE_EMPTY) {
            $arrayzy = $this->createArrayzy($array);
            $arrayzy2 = clone $arrayzy;

            $randomKeys = $arrayzy->getRandomKeys(2);

            foreach ($arrayzy as $key => $value) {
                if (!in_array($key, $randomKeys)) {
                    $arrayzy->offsetUnset($key);
                }
            }

            $this->assertSame($arrayzy2->only($randomKeys)->toArray(), $arrayzy->toArray());
        }
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testPrevious(array $array)
    {
        $arrayzy = $this->createArrayzy($array);
        $prev = prev($array);

        $this->assertSame($prev, $arrayzy->previous());
    }

    public function testReduce()
    {
        $func = function($carry, $value) {
            $carry += $value;

            return $carry;
        };
        $array = [1, 2, 3];
        $arrayzy = $this->createArrayzy($array);
        $arrayzyReduced = $arrayzy->reduce($func);
        $arrayReduced = array_reduce($array, $func);

        $this->assertSame($arrayReduced, $arrayzyReduced);
    }

    /**
     * @dataProvider simpleArrayProvider
     *
     * @param array $array
     */
    public function testToJson(array $array)
    {
        $json = json_encode($array);

        $arrayzy = $this->createArrayzy($array);

        $this->assertSame($json, $arrayzy->toJson());
    }

    public function testToReadableString()
    {
        $arrayzy0 = $this->createArrayzy([]);
        $this->assertEquals('', $arrayzy0->toReadableString(', ', ' and '));

        $arrayzy1 = $this->createArrayzy(['a']);
        $this->assertEquals('a', $arrayzy1->toReadableString(', ', ' and '));

        $arrayzy2 = $this->createArrayzy(['a', 'b']);
        $this->assertEquals('a and b', $arrayzy2->toReadableString(', ', ' and '));

        $arrayzy3 = $this->createArrayzy(['a', 'b', 'c']);
        $this->assertEquals('a + b and c', $arrayzy3->toReadableString(' + ', ' and '));

        $arrayzy4 = $this->createArrayzy(['a', 'b', 'c', 'd']);
        $this->assertEquals('a, b, c or d', $arrayzy4->toReadableString(', ', ' or '));
    }

    /**
     * @dataProvider stringWithSeparatorProvider
     *
     * @param string $string
     * @param string $separator
     */
    public function testToString($string, $separator)
    {
        $array = explode($separator, $string);

        $arrayzy = $this->createArrayzy($array);
        $resultString = implode(', ', $array);

        $this->assertSame($resultString, (string)$arrayzy);
        $this->assertSame($string, $arrayzy->toString($separator));
    }
}
