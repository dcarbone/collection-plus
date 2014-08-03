<?php

require_once realpath(__DIR__.'/collection-plus-test-scripts/functions.php');

/**
 * Class BaseCollectionPlusTest
 */
class BaseCollectionPlusTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @return BaseCollectionPlusTest
     */
    public function testCollectionCanBeConstructedFromValidConstructorArguments()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus(array('test' => 'value'));
        $this->assertInstanceOf('DCarbone\\CollectionPlus\\AbstractCollectionPlus', $collection);
        return $collection;
    }

    /**
     * @covers \DCarbone\CollectionPlus::AbstractCollectionPlus::count
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\CollectionPlus\BaseCollectionPlus $collection
     */
    public function testCountableImplementationCorrect(\DCarbone\CollectionPlus\BaseCollectionPlus $collection)
    {
        $this->assertInstanceOf('Countable', $collection);
        $this->assertEquals(1, count($collection));
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::serialize
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::unserialize
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\CollectionPlus\BaseCollectionPlus $collection
     */
    public function testSerializableImplementationCorrect(\DCarbone\CollectionPlus\BaseCollectionPlus $collection)
    {
        $this->assertInstanceOf('Serializable', $collection);

        $serialized = serialize($collection);
        $this->assertTrue(
            is_string($serialized),
            'Saw non-string value "'.gettype($serialized).'" from "AbstractTraversableClass::serialize"');

        $unserialized = unserialize($serialized);
        $this->assertInstanceOf(
            'DCarbone\\CollectionPlus\\AbstractCollectionPlus',
            $unserialized);

        $this->assertArrayHasKey('test', $unserialized);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::offsetExists
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::offsetUnset
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::offsetGet
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @uses \DCarbone\CollectionPlus\BaseCollectionPlus
     */
    public function testArrayAccessImplementationCorrect()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus(array(
            'key1' => 'value1',
            'key2' => 'value2',
            0 => 'value3'
        ));

        $this->assertInstanceOf('ArrayAccess', $collection);

        $this->assertTrue(isset($collection['key1']));
        $this->assertArrayHasKey('key1', $collection);
        $this->assertEquals('value1', $collection['key1']);

        $this->assertTrue(isset($collection['key1']));
        $this->assertArrayHasKey('key2', $collection);
        $this->assertEquals('value2', $collection['key2']);

        $this->assertTrue(isset($collection[0]));
        $this->assertArrayHasKey(0, $collection);
        $this->assertEquals('value3', $collection[0]);

        unset($collection[0]);
        $this->assertArrayNotHasKey(0, $collection);
        $this->assertNotTrue(isset($collection[0]));

        $collection[2] = 'value4';

        $this->assertArrayHasKey(2, $collection);
        $this->assertEquals('value4', $collection[2]);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__get
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__set
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testGetSetImplementationCorrect()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus(array(
            'key1' => 'value1',
            'key2' => 'value2',
            0 => 'value3'
        ));

        $this->assertInstanceOf(
            'DCarbone\\CollectionPlus\\AbstractCollectionPlus',
            $collection);

        $this->assertTrue(
            method_exists($collection, '__get'),
            '"$collection" object did not contain public method "__get"');
        $this->assertTrue(
            method_exists($collection, '__set'),
            '"$collection" object did not contain public method "__set"');

        $key1 = $collection->key1;
        $this->assertEquals('value1', $key1);

        $key2 = $collection->key2;
        $this->assertEquals('value2', $key2);

        $_0 = $collection->{'0'};
        $this->assertEquals('value3', $_0);

        $collection->{'0'} = 'new value3';
        $_00 = $collection->{'0'};
        $this->assertEquals('new value3', $_00);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__toString
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\CollectionPlus\AbstractCollectionPlus $collection
     */
    public function testCollectionCanBeTypecastAsString(\DCarbone\CollectionPlus\AbstractCollectionPlus $collection)
    {
        $string = (string)$collection;
        $this->assertTrue(is_string($string));
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::array_keys
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\CollectionPlus\AbstractCollectionPlus $collection
     */
    public function testCanGetArrayKeysOfCollection(\DCarbone\CollectionPlus\AbstractCollectionPlus $collection)
    {
        $keys = $collection->array_keys();
        $this->assertTrue(is_array($keys), '"$collection->array_keys()" did not return an array!');
        $this->assertEquals(1, count($keys));
        $this->assertContains('test', $keys, 'Did not see key "test" in "$collection->array_keys()" result');
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::exchangeArray
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testCanUseExchangeArrayWithArrayParameter()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus(array('test' => 'value'));

        $this->assertTrue(
            method_exists($collection, 'exchangeArray'),
            '"$collection" object did not contain public method "exchangeArray"');

        $newArray = array(
            'new-key' => 'new-value'
        );

        $oldArray = $collection->exchangeArray($newArray);
        $this->assertTrue(
            is_array($oldArray),
            'Saw "'.gettype($oldArray).'" non-array response from "$collection::exchangeArray"');

        $this->assertArrayNotHasKey('test', $collection);
        $this->assertArrayHasKey('new-key', $collection);
        $this->assertEquals('new-value', $collection['new-key']);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::exchangeArray
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testCanUseExchangeArrayWithStdClassParameter()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus(array('test' => 'value'));

        $this->assertTrue(
            method_exists($collection, 'exchangeArray'),
            '"$collection" object did not contain public method "exchangeArray"');

        $newObject = (object) array(
            'new-key' => 'new-value'
        );

        $oldArray = $collection->exchangeArray($newObject);
        $this->assertTrue(
            is_array($oldArray),
            'Saw "'.gettype($oldArray).'" non-array response from "$collection::exchangeArray"');

        $this->assertArrayNotHasKey('test', $collection);
        $this->assertArrayHasKey('new-key', $collection);
        $this->assertEquals('new-value', $collection['new-key']);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::exchangeArray
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testCanUseExchangeArrayWithSelfParameter()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus(array('test' => 'value'));

        $this->assertTrue(
            method_exists($collection, 'exchangeArray'),
            '"$collection" object did not contain public method "exchangeArray"');

        $newSelf = new \DCarbone\CollectionPlus\BaseCollectionPlus(array('new-key' => 'new-value'));

        $oldArray = $collection->exchangeArray($newSelf);
        $this->assertTrue(
            is_array($oldArray),
            'Saw "'.gettype($oldArray).'" non-array response from "$collection::exchangeArray"');

        $this->assertArrayNotHasKey('test', $collection);
        $this->assertArrayHasKey('new-key', $collection);
        $this->assertEquals('new-value', $collection['new-key']);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::exchangeArray
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @uses \ArrayObject
     */
    public function testCanUseExchangeArrayWithArrayObjectParameter()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus(array('test' => 'value'));

        $this->assertTrue(
            method_exists($collection, 'exchangeArray'),
            '"$collection" object did not contain public method "exchangeArray"');

        $newArrayObject = new ArrayObject(array('new-key' => 'new-value'));

        $oldArray = $collection->exchangeArray($newArrayObject);
        $this->assertTrue(
            is_array($oldArray),
            'Saw "'.gettype($oldArray).'" non-array response from "$collection::exchangeArray"');

        $this->assertArrayNotHasKey('test', $collection);
        $this->assertArrayHasKey('new-key', $collection);
        $this->assertEquals('new-value', $collection['new-key']);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::set
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::append
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::contains
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::first
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::last
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::indexOf
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::count
     * @uses \DCarbone\CollectionPlus\AbstractTraversableClass
     */
    public function testHelperMethodImplementationsCorrect()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();

        $this->assertTrue(
            method_exists($collection, 'set'),
            '"$collection" object did not contain public method "set"');
        $this->assertTrue(
            method_exists($collection, 'append'),
            '"$collection" object did not contain public method "append"');
        $this->assertTrue(
            method_exists($collection, 'contains'),
            '"$collection" object did not contain public method "contains"');
        $this->assertTrue(
            method_exists($collection,'first'),
            '"$collection" object did not contain public method "first"');
        $this->assertTrue(
            method_exists($collection, 'last'),
            '"$collection" object did not contain public method "last"');
        $this->assertTrue(
            method_exists($collection, 'indexOf'),
            '"$collection" object did not contain public method "indexOf"');

        $collection->set('key1', 'value1');
        $this->assertArrayHasKey('key1', $collection);

        $collection->append('value2');
        $idx = $collection->indexOf('value2');
        $this->assertEquals(
            2,
            count($collection),
            '"count($collection)" did not yield the expected result of 2');
        $this->assertNotFalse(
            $idx,
            'Unable to use "AbstractCollectionPlus::indexOf" to find index of "value2"');
        $this->assertEquals(
            0,
            $idx,
            '"AbstractCollectionPlus::indexOf" returned incorrect value.  Expected "0", saw "'.$idx.'"');

        $firstValue = $collection->first();
        $lastValue = $collection->last();
        $this->assertEquals('value1', $firstValue);
        $this->assertEquals('value2', $lastValue);

        $this->assertTrue($collection->contains('value2'));
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::exists
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\CollectionPlus\BaseCollectionPlus $collection
     */
    public function testExistsWithStringGlobalFunctionName(\DCarbone\CollectionPlus\BaseCollectionPlus $collection)
    {
        $shouldExist = $collection->exists('_exists_function_success_test');
        $shouldNotExist = $collection->exists('_exists_function_failure_test');

        $this->assertTrue($shouldExist);
        $this->assertNotTrue($shouldNotExist);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::exists
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @uses \ExistsTests
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\CollectionPlus\BaseCollectionPlus $collection
     */
    public function testExistsWithStringObjectStaticMethodName(\DCarbone\CollectionPlus\BaseCollectionPlus $collection)
    {
        $shouldExist = $collection->exists(array('\\ExistsTests', '_exists_function_success_test'));
        $shouldNotExist = $collection->exists(array('\\ExistsTests', '_exists_function_failure_test'));

        $this->assertTrue($shouldExist);
        $this->assertNotTrue($shouldNotExist);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::exists
     * @uses \DCarboneCollectionPlus\AbstractCollectionPlus
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\CollectionPlus\BaseCollectionPlus $collection
     */
    public function testExistsWithAnonymousFunction(\DCarbone\CollectionPlus\BaseCollectionPlus $collection)
    {
        $shouldExist = $collection->exists(function($key, $value) {
            return ($key === 'test' && $value === 'value');
        });

        $shouldNotExist = $collection->exists(function($key, $value) {
            return ($key === 'tasty' && $value === 'sandwich');
        });

        $this->assertTrue($shouldExist);
        $this->assertNotTrue($shouldNotExist);
    }
}