<?php

date_default_timezone_set('UTC');

require_once realpath(__DIR__.'/collection-plus-test-scripts/functions.php');
require_once realpath(__DIR__.'/collection-plus-test-scripts/classes.php');

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
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @return \DCarbone\CollectionPlus\BaseCollectionPlus
     */
    public function testCollectionCanBeConstructedWithNoConstructorArguments()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();
        $this->assertInstanceOf('DCarbone\\CollectionPlus\\AbstractCollectionPlus', $collection);
        return $collection;
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::count
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
            'Saw non-string value "'.gettype($serialized).'" from "AbstractCollectionPlus::serialize"');

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

        // First, falsy tests
        $this->assertFalse(isset($collection['sandwich']));
        $this->assertNull($collection['sandwich']);

        // Next, truthy tests
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
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::offsetUnset
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @expectedException \OutOfBoundsException
     */
    public function testExceptionThrownWhenInvalidOffsetUnset()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus(array(
            'key1' => 'value1',
            'key2' => 'value2',
            0 => 'value3'
        ));

        unset($collection['sandwiches']);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__get
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__set
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testMagicMethodsGetAndSetImplementationCorrect()
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
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__toArray
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\CollectionPlus\AbstractCollectionPlus $collection
     */
    public function testCanGetInternalStorageArrayOfCollection(\DCarbone\CollectionPlus\AbstractCollectionPlus $collection)
    {
        $array = $collection->__toArray();
        $this->assertTrue(is_array($array));
        $this->assertEquals(1, count($array));
        $this->assertArrayHasKey('test', $array);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__toArray
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::jsonSerialize
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\CollectionPlus\AbstractCollectionPlus $collection
     */
    public function testCanGetJsonSerializedRepresentationOfCollectionData(\DCarbone\CollectionPlus\AbstractCollectionPlus $collection)
    {
        if (version_compare(PHP_VERSION, '5.4.0', 'lt'))
        {
            $this->assertInstanceOf('\\DCarbone\\CollectionPlus\\JsonSerializable', $collection);
            $json = json_encode($collection->jsonSerialize());
        }
        else
        {
            $this->assertInstanceOf('\\JsonSerializable', $collection);
            $json = json_encode($collection);
        }

        $this->assertTrue(
            (json_last_error() === JSON_ERROR_NONE),
            '"json_encode" returned error "'.json_last_error().'"');

        $this->assertTrue(
            is_string($json),
            '"json_encode" returned non-string value');
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::keys
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\CollectionPlus\AbstractCollectionPlus $collection
     */
    public function testCanGetKeysOfCollection(\DCarbone\CollectionPlus\AbstractCollectionPlus $collection)
    {
        $keys = $collection->keys();
        $this->assertTrue(is_array($keys), '"$collection->keys()" did not return an array!');
        $this->assertEquals(1, count($keys));

        $this->assertContains(
            'test',
            $keys,
            'Did not see key "test" in "$collection->keys()" result');
    }

    /**
     * @covers  \DCarbone\CollectionPlus\AbstractCollectionPlus::array_keys
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\CollectionPlus\AbstractCollectionPlus|\DCarbone\CollectionPlus\BaseCollectionPlus $collection
     */
    public function testCanUseDeprecatedArrayKeysMethod(\DCarbone\CollectionPlus\BaseCollectionPlus $collection)
    {
        $keys = $collection->array_keys();
        $this->assertTrue(is_array($keys));
        $this->assertEquals(1, count($keys));

        $this->assertContains('test', $keys);
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
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__toArray
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
     * @covers \ArrayObject::getArrayCopy
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
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::exchangeArray
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionIsRaisedForInvalidExchangeArrayParameter()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus(array('test' => 'value'));

        $this->assertTrue(
            method_exists($collection, 'exchangeArray'),
            '"$collection" object did not contain public method "exchangeArray"');

        $newData = 42;

        $collection->exchangeArray($newData);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::set
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testSetMethodImplementation()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();

        $this->assertTrue(
            method_exists($collection, 'set'),
            '"$collection" object did not contain public method "set"');

        $collection->set('key1', 'value1');
        $this->assertArrayHasKey('key1', $collection);
        $this->assertEquals('value1', $collection['key1']);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::append
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testAppendMethodImplementation()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();

        $this->assertTrue(
            method_exists($collection, 'append'),
            '"$collection" object did not contain public method "append"');

        $collection->append('value1');
        $this->assertArrayHasKey(0, $collection);
        $this->assertEquals('value1', $collection[0]);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::contains
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @depends testSetMethodImplementation
     */
    public function testContainsMethodImplementation()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();

        $this->assertTrue(
            method_exists($collection, 'contains'),
            '"$collection" object did not contain public method "contains"');

        $collection->set('key1', 'value1');
        $contains = $collection->contains('value1');

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::indexOf
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @depends testSetMethodImplementation
     */
    public function testIndexOfMethodImplementation()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();

        $this->assertTrue(
            method_exists($collection, 'indexOf'),
            '"$collection" object did not contain public method "indexOf"');

        $collection->set('key1', 'value1');
        $idxValue = $collection->indexOf('value1');
        $idxFalse = $collection->indexOf('value2');

        $this->assertNotFalse($idxValue);
        $this->assertArrayHasKey($idxValue, $collection);
        $this->assertFalse($idxFalse);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::remove
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @depends testSetMethodImplementation
     */
    public function testCanRemoveElementFromCollectionByIndex()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();

        $collection->set('key1', 'value1');

        $this->assertEquals(1, count($collection));

        $removed = $collection->remove('key1');
        $this->assertEquals('value1', $removed);

        $this->assertEquals(0, count($collection));
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::removeElement
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @depends testSetMethodImplementation
     */
    public function testCanRemoveElementFromCollectionByElement()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();

        $value = array('value1');
        $collection->set('key1', $value);

        $this->assertEquals(1, count($collection));

        $removed = $collection->removeElement($value);
        $this->assertTrue((array('value1') == $removed));
        $this->assertEquals(0, count($collection));
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::isEmpty
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testEmptyMethodWhenCollectionEmpty()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();

        $this->assertTrue($collection->isEmpty());
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::isEmpty
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testEmptyMethodWhenCollectionNotEmpty()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus(array('test' => 'value'));
        $this->assertFalse($collection->isEmpty());
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::set
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::append
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::first
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::last
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::isEmpty
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::removeElement
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testCollectionFirstAndLastMethods()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();

        $this->assertTrue(
            method_exists($collection,'first'),
            '"$collection" object did not contain public method "first"');
        $this->assertTrue(
            method_exists($collection, 'last'),
            '"$collection" object did not contain public method "last"');

        $collection->set('key1', 'value1');
        $firstValue = $collection->first();
        $lastValue = $collection->last();
        $this->assertEquals('value1', $firstValue);
        $this->assertEquals('value1', $lastValue);

        $collection->set('key2', 'value2');
        $firstValue = $collection->first();
        $lastValue = $collection->last();
        $this->assertEquals('value1', $firstValue);
        $this->assertEquals('value2', $lastValue);

        $collection->append('value3');
        $firstValue = $collection->first();
        $lastValue = $collection->last();
        $this->assertEquals('value1', $firstValue);
        $this->assertEquals('value3', $lastValue);

        $collection->removeElement('value3');
        $firstValue = $collection->first();
        $lastValue = $collection->last();
        $this->assertEquals('value1', $firstValue);
        $this->assertEquals('value2', $lastValue);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::set
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::append
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::getFirstKey
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::getLastKey
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::removeElement
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testCollectionFirstKeyAndLastKeyMethods()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();

        $this->assertTrue(
            method_exists($collection,'getFirstKey'),
            '"$collection" object did not contain public method "getFirstKey"');
        $this->assertTrue(
            method_exists($collection, 'getLastKey'),
            '"$collection" object did not contain public method "getLastKey"');

        $collection->set('key1', 'value1');
        $firstKey = $collection->getFirstKey();
        $lastKey = $collection->getLastKey();
        $this->assertEquals('key1', $firstKey);
        $this->assertEquals('key1', $lastKey);

        $collection->set('key2', 'value2');
        $firstKey = $collection->getFirstKey();
        $lastKey = $collection->getLastKey();
        $this->assertEquals('key1', $firstKey);
        $this->assertEquals('key2', $lastKey);

        $collection->append('value3');
        $firstKey = $collection->getFirstKey();
        $lastKey = $collection->getLastKey();
        $this->assertEquals('key1', $firstKey);
        $this->assertEquals(0, $lastKey);

        $collection->removeElement('value3');
        $firstKey = $collection->getFirstKey();
        $lastKey = $collection->getLastKey();
        $this->assertEquals('key1', $firstKey);
        $this->assertEquals('key2', $lastKey);
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
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
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

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::setIteratorClass
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::getIteratorClass
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testCanSetValidIteratorClassWithLeadingSlashes()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();
        $collection->setIteratorClass('\\ArrayIterator');
        $this->assertTrue(
            ('\\ArrayIterator' === $collection->getIteratorClass()));
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::setIteratorClass
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::getIteratorClass
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testCanSetValidIteratorClassWithoutLeadingSlashes()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();
        $collection->setIteratorClass('ArrayIterator');

        $this->assertTrue(
            ('\\ArrayIterator' === $collection->getIteratorClass()));
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::setIteratorClass
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionThrownWhenUndefinedIteratorClassSet()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();
        $collection->setIteratorClass('\\MyAwesomeIterator');
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::getIterator
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @uses \ArrayIterator
     */
    public function testCanGetDefaultIteratorClass()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus(
            array('key1' => 'value1', 'key2' => 'value2'));

        $arrayIterator = $collection->getIterator();

        $this->assertInstanceOf('\\ArrayIterator', $arrayIterator);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::setIteratorClass
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::getIterator
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @uses \MySuperAwesomeIteratorClass
     */
    public function testCanGetCustomIteratorClass()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus(
            array('key1' => 'value1', 'key2' => 'value2'));

        $collection->setIteratorClass('\\MySuperAwesomeIteratorClass');

        $arrayIterator = $collection->getIterator();

        $this->assertInstanceOf('\\MySuperAwesomeIteratorClass', $arrayIterator);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::map
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @expectedException \InvalidArgumentException
     */
    public function testMapThrowsExceptionWhenUncallableFuncPassed()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();
        $collection->map('this_function_doesnt_exist');
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::map
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::initNew
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::count
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testMapWithGlobalFunction()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();
        for($i = 0; $i < 10; $i++)
            $collection[] = $i;

        $this->assertEquals(10, count($collection));

        $mapped = $collection->map('_map_function_change_odd_values_to_null');
        $this->assertEquals(10, count($mapped));

        $this->assertNull($mapped[1]);
        $this->assertNotNull($mapped[0]);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::map
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::initNew
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::count
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testMapWithObjectStaticMethod()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();
        for($i = 0; $i < 10; $i++)
            $collection[] = $i;

        $this->assertEquals(10, count($collection));

        $mapped = $collection->map(array('MapTests', '_map_function_change_odd_values_to_null'));
        $this->assertEquals(10, count($mapped));

        $this->assertNull($mapped[1]);
        $this->assertNotNull($mapped[0]);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::map
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::initNew
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::count
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testMapWithAnonymousFunction()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();
        for($i = 0; $i < 10; $i++)
            $collection[] = $i;

        $mapped = $collection->map(function ($value) {
            if ($value % 2 === 0)
                return $value;

            return null;
        });
        $this->assertEquals(10, count($mapped));

        $this->assertNull($mapped[1]);
        $this->assertNotNull($mapped[0]);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::map
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::initNew
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::count
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @uses \MySuperAwesomeCollectionClass
     */
    public function testMapWithAnonymousFunctionReturnsInstanceOfExtendedClass()
    {
        $collection = new MySuperAwesomeCollectionClass();

        for($i = 0; $i < 10; $i++)
            $collection[] = $i;

        $mapped = $collection->map(function ($value) {
            if ($value % 2 === 0)
                return $value;

            return null;
        });
        $this->assertEquals(10, count($mapped));

        $this->assertNull($mapped[1]);
        $this->assertNotNull($mapped[0]);

        $this->assertInstanceOf('\\MySuperAwesomeCollectionClass', $mapped);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::filter
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::initNew
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::count
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testFilterWithNoCallableParameter()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();
        for($i = 1; $i <= 10; $i++)
        {
            if ($i % 2 === 0)
                $collection[] = true;
            else
                $collection[] = false;
        }

        $this->assertEquals(10, count($collection));

        $filtered = $collection->filter();
        $this->assertEquals(5, count($filtered));
        $this->assertNotContains(false, $filtered);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::filter
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::initNew
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::count
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testFilterWithGlobalFunction()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();
        for($i = 1; $i <= 10; $i++)
        {
            if ($i % 2 === 0)
                $collection[] = true;
            else
                $collection[] = false;
        }

        $this->assertEquals(10, count($collection));

        $filtered = $collection->filter('_filter_function_remove_true_values');
        $this->assertEquals(5, count($filtered));
        $this->assertNotContains(true, $filtered);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::filter
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::initNew
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::count
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testFilterWithObjectStaticFunction()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();
        for($i = 1; $i <= 10; $i++)
        {
            if ($i % 2 === 0)
                $collection[] = true;
            else
                $collection[] = false;
        }

        $this->assertEquals(10, count($collection));

        $filtered = $collection->filter(array('FilterTests', '_filter_function_remove_true_values'));
        $this->assertEquals(5, count($filtered));
        $this->assertNotContains(true, $filtered);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::filter
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::initNew
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::count
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testFilterWithAnonymousFunction()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus();
        for($i = 1; $i <= 10; $i++)
        {
            if ($i % 2 === 0)
                $collection[] = true;
            else
                $collection[] = false;
        }

        $this->assertEquals(10, count($collection));

        $filtered = $collection->filter(function ($value) {
            return ($value === false);
        });

        $this->assertEquals(5, count($filtered));
        $this->assertNotContains(true, $filtered);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::filter
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::initNew
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::count
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     */
    public function testFilterWithAnonymousFunctionReturnsInstanceOfExtendedClass()
    {
        $collection = new MySuperAwesomeCollectionClass();
        for($i = 1; $i <= 10; $i++)
        {
            if ($i % 2 === 0)
                $collection[] = true;
            else
                $collection[] = false;
        }

        $this->assertEquals(10, count($collection));

        $filtered = $collection->filter(function ($value) {
            return ($value === false);
        });

        $this->assertInstanceOf('\\MySuperAwesomeCollectionClass', $filtered);
        $this->assertEquals(5, count($filtered));
        $this->assertNotContains(true, $filtered);
    }
}