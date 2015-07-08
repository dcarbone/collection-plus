<?php

date_default_timezone_set('UTC');

require_once __DIR__.'/../misc/functions.php';
require_once __DIR__.'/../misc/classes.php';

/**
 * Class CollectionPlusTest
 */
class CollectionPlusTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @uses \DCarbone\AbstractCollectionPlus
     * @return CollectionPlusTest
     */
    public function testCollectionCanBeConstructedFromValidConstructorArguments()
    {
        $collection = new \DCarbone\CollectionPlus(array('test' => 'value'));
        $this->assertInstanceOf('DCarbone\\AbstractCollectionPlus', $collection);
        return $collection;
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @uses \DCarbone\AbstractCollectionPlus
     * @return \DCarbone\CollectionPlus
     */
    public function testCollectionCanBeConstructedWithNoConstructorArguments()
    {
        $collection = new \DCarbone\CollectionPlus();
        $this->assertInstanceOf('DCarbone\\AbstractCollectionPlus', $collection);
        return $collection;
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::count
     * @uses \DCarbone\AbstractCollectionPlus
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\CollectionPlus $collection
     */
    public function testCountableImplementationCorrect(\DCarbone\CollectionPlus $collection)
    {
        $this->assertInstanceOf('Countable', $collection);
        $this->assertEquals(1, count($collection));
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::serialize
     * @covers \DCarbone\AbstractCollectionPlus::unserialize
     * @uses \DCarbone\AbstractCollectionPlus
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\CollectionPlus $collection
     */
    public function testSerializableImplementationCorrect(\DCarbone\CollectionPlus $collection)
    {
        $this->assertInstanceOf('Serializable', $collection);

        $serialized = serialize($collection);
        $this->assertTrue(
            is_string($serialized),
            'Saw non-string value "'.gettype($serialized).'" from "AbstractCollectionPlus::serialize"');

        $unserialized = unserialize($serialized);
        $this->assertInstanceOf(
            'DCarbone\\AbstractCollectionPlus',
            $unserialized);

        $this->assertArrayHasKey('test', $unserialized);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::offsetExists
     * @covers \DCarbone\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\AbstractCollectionPlus::offsetUnset
     * @covers \DCarbone\AbstractCollectionPlus::offsetGet
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testArrayAccessImplementationCorrect()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'key1' => 'value1',
            'key2' => 'value2',
            0 => 'value3'
        ));

        $this->assertInstanceOf('ArrayAccess', $collection);

        // First, falsy tests
        $this->assertFalse(isset($collection['sandwich']));

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
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::__get
     * @covers \DCarbone\AbstractCollectionPlus::__set
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testMagicMethodsGetAndSetImplementationCorrect()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'key1' => 'value1',
            'key2' => 'value2',
            0 => 'value3'
        ));

        $this->assertInstanceOf(
            'DCarbone\\AbstractCollectionPlus',
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
     * @covers \DCarbone\AbstractCollectionPlus::__get
     * @expectedException \OutOfBoundsException
     */
    public function testExceptionThrownWhenInvalidParameterSentTo__getMethod()
    {
        $collection = new \DCarbone\CollectionPlus();
        $collection->key;
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__toString
     * @uses \DCarbone\AbstractCollectionPlus
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testCollectionCanBeTypecastAsString(\DCarbone\AbstractCollectionPlus $collection)
    {
        $string = (string)$collection;
        $this->assertTrue(is_string($string));
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::getArrayCopy
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testCanGetInternalStorageArrayOfCollection(\DCarbone\AbstractCollectionPlus $collection)
    {
        $array = $collection->getArrayCopy();
        $this->assertTrue(is_array($array));
        $this->assertEquals(1, count($array));
        $this->assertArrayHasKey('test', $array);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::getArrayCopy
     * @covers \DCarbone\AbstractCollectionPlus::jsonSerialize
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testCanGetJsonSerializedRepresentationOfCollectionData(\DCarbone\AbstractCollectionPlus $collection)
    {
        if (version_compare(PHP_VERSION, '5.4.0', 'lt'))
        {
            $this->assertInstanceOf('\\DCarbone\\JsonSerializable', $collection);
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
     * @covers \DCarbone\AbstractCollectionPlus::keys
     * @uses \DCarbone\AbstractCollectionPlus
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testCanGetKeysOfCollection(\DCarbone\AbstractCollectionPlus $collection)
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
     * @covers  \DCarbone\AbstractCollectionPlus::__toArray
     * @uses \DCarbone\AbstractCollectionPlus
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\AbstractCollectionPlus|\DCarbone\CollectionPlus $collection
     */
    public function testCanUseDeprecatedMethod__toArray(\DCarbone\CollectionPlus $collection)
    {
        $array = $collection->__toArray();
        $this->assertTrue(is_array($array));
        $this->assertEquals(1, count($array));

        $this->assertArrayHasKey('test', $array);
        $this->assertContains('value', $array);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::exchangeArray
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testCanUseExchangeArrayWithArrayParameter()
    {
        $collection = new \DCarbone\CollectionPlus(array('test' => 'value'));

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
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::exchangeArray
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testCanUseExchangeArrayWithStdClassParameter()
    {
        $collection = new \DCarbone\CollectionPlus(array('test' => 'value'));

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
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::exchangeArray
     * @covers \DCarbone\AbstractCollectionPlus::getArrayCopy
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testCanUseExchangeArrayWithSelfParameter()
    {
        $collection = new \DCarbone\CollectionPlus(array('test' => 'value'));

        $this->assertTrue(
            method_exists($collection, 'exchangeArray'),
            '"$collection" object did not contain public method "exchangeArray"');

        $newSelf = new \DCarbone\CollectionPlus(array('new-key' => 'new-value'));

        $oldArray = $collection->exchangeArray($newSelf);
        $this->assertTrue(
            is_array($oldArray),
            'Saw "'.gettype($oldArray).'" non-array response from "$collection::exchangeArray"');

        $this->assertArrayNotHasKey('test', $collection);
        $this->assertArrayHasKey('new-key', $collection);
        $this->assertEquals('new-value', $collection['new-key']);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::exchangeArray
     * @uses \ArrayObject
     */
    public function testCanUseExchangeArrayWithArrayObjectParameter()
    {
        $collection = new \DCarbone\CollectionPlus(array('test' => 'value'));

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
     * @covers \DCarbone\AbstractCollectionPlus::exchangeArray
     * @uses \SplFixedArray
     */
    public function testCanUseExchangeArrayWithSplFixedArray()
    {
        $collection = new \DCarbone\CollectionPlus();
        $fixedArray = new \SplFixedArray(1);
        $fixedArray[0] = 'test';

        $collection->exchangeArray($fixedArray);
        $this->assertCount(1, $collection);
        $this->assertContains('test', $collection);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::exchangeArray
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionIsRaisedWhenNonArrayOrObjectPassedToExchangeArray()
    {
        $collection = new \DCarbone\CollectionPlus(array('test' => 'value'));

        $this->assertTrue(
            method_exists($collection, 'exchangeArray'),
            '"$collection" object did not contain public method "exchangeArray"');

        $newData = 42;

        $collection->exchangeArray($newData);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::exchangeArray
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionThrownWhenInvalidObjectPassedToExchangeArray()
    {
        $collection = new \DCarbone\CollectionPlus();
        $class = new im_just_a_class();
        $collection->exchangeArray($class);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::set
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testSetMethodImplementation()
    {
        $collection = new \DCarbone\CollectionPlus();

        $this->assertTrue(
            method_exists($collection, 'set'),
            '"$collection" object did not contain public method "set"');

        $collection->set('key1', 'value1');
        $this->assertArrayHasKey('key1', $collection);
        $this->assertEquals('value1', $collection['key1']);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::append
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testAppendMethodImplementation()
    {
        $collection = new \DCarbone\CollectionPlus();

        $this->assertTrue(
            method_exists($collection, 'append'),
            '"$collection" object did not contain public method "append"');

        $collection->append('value1');

        $this->assertArrayHasKey(0, $collection);
        $this->assertEquals('value1', $collection[0]);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::contains
     * @uses \DCarbone\AbstractCollectionPlus
     * @depends testSetMethodImplementation
     */
    public function testContainsMethodImplementation()
    {
        $collection = new \DCarbone\CollectionPlus();

        $this->assertTrue(
            method_exists($collection, 'contains'),
            '"$collection" object did not contain public method "contains"');

        $collection->set('key1', 'value1');
        $contains = $collection->contains('value1');

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::indexOf
     * @uses \DCarbone\AbstractCollectionPlus
     * @depends testSetMethodImplementation
     */
    public function testIndexOfMethodImplementation()
    {
        $collection = new \DCarbone\CollectionPlus();

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
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::remove
     * @uses \DCarbone\AbstractCollectionPlus
     * @depends testSetMethodImplementation
     */
    public function testCanRemoveElementFromCollectionByIndex()
    {
        $collection = new \DCarbone\CollectionPlus();

        $collection->set('key1', 'value1');

        $this->assertEquals(1, count($collection));

        $removed = $collection->remove('key1');
        $this->assertEquals('value1', $removed);

        $this->assertEquals(0, count($collection));
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::remove
     */
    public function testCanRemoveNullValueFromCollectionByIndex()
    {
        $collection = new \DCarbone\CollectionPlus(array(null));
        $this->assertCount(1, $collection);
        $this->assertContains(null, $collection);

        $removed = $collection->remove(0);
        $this->assertEquals(null, $removed);
        $this->assertCount(0, $collection);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::remove
     */
    public function testNullReturnedWhenRemovingInvalidIndex()
    {
        $collection = new \DCarbone\CollectionPlus(array('value'));
        $this->assertCount(1, $collection);
        $value = $collection->remove(1);
        $this->assertNull($value);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::removeElement
     * @uses \DCarbone\AbstractCollectionPlus
     * @depends testSetMethodImplementation
     */
    public function testCanRemoveElementFromCollectionByElement()
    {
        $collection = new \DCarbone\CollectionPlus();

        $value = array('value1');
        $collection->set('key1', $value);

        $this->assertEquals(1, count($collection));

        $removed = $collection->removeElement($value);
        $this->assertTrue((array('value1') == $removed));
        $this->assertEquals(0, count($collection));
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::isEmpty
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testEmptyMethodWhenCollectionEmpty()
    {
        $collection = new \DCarbone\CollectionPlus();

        $this->assertTrue($collection->isEmpty());
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::isEmpty
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testEmptyMethodWhenCollectionNotEmpty()
    {
        $collection = new \DCarbone\CollectionPlus(array('test' => 'value'));
        $this->assertFalse($collection->isEmpty());
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::first
     * @covers \DCarbone\AbstractCollectionPlus::last
     * @covers \DCarbone\AbstractCollectionPlus::_updateKeys
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testCollectionFirstAndLastMethods()
    {
        $collection = new \DCarbone\CollectionPlus();

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
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::set
     * @covers \DCarbone\AbstractCollectionPlus::append
     * @covers \DCarbone\AbstractCollectionPlus::getFirstKey
     * @covers \DCarbone\AbstractCollectionPlus::getLastKey
     * @covers \DCarbone\AbstractCollectionPlus::removeElement
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testCollectionFirstKeyAndLastKeyMethods()
    {
        $collection = new \DCarbone\CollectionPlus();

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
     * @covers \DCarbone\AbstractCollectionPlus::exists
     * @uses \DCarbone\AbstractCollectionPlus
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\CollectionPlus $collection
     */
    public function testExistsWithStringGlobalFunctionName(\DCarbone\CollectionPlus $collection)
    {
        $shouldExist = $collection->exists('_collection_exists_success_test');
        $shouldNotExist = $collection->exists('_collection_exists_failure_test');

        $this->assertTrue($shouldExist);
        $this->assertNotTrue($shouldNotExist);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::exists
     * @uses \DCarbone\AbstractCollectionPlus
     * @uses \CollectionPlusTests
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\CollectionPlus $collection
     */
    public function testExistsWithStringObjectStaticMethodName(\DCarbone\CollectionPlus $collection)
    {
        $shouldExist = $collection->exists(array('\\CollectionPlusTests', '_collection_exists_success_test'));
        $shouldNotExist = $collection->exists(array('\\CollectionPlusTests', '_collection_exists_failure_test'));

        $this->assertTrue($shouldExist);
        $this->assertNotTrue($shouldNotExist);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::exists
     * @uses \DCarbone\AbstractCollectionPlus
     * @depends testCollectionCanBeConstructedFromValidConstructorArguments
     * @param \DCarbone\CollectionPlus $collection
     */
    public function testExistsWithAnonymousFunction(\DCarbone\CollectionPlus $collection)
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
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::setIteratorClass
     * @covers \DCarbone\AbstractCollectionPlus::getIteratorClass
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testCanSetValidIteratorClassWithLeadingSlashes()
    {
        $collection = new \DCarbone\CollectionPlus();
        $collection->setIteratorClass('\\ArrayIterator');
        $this->assertTrue(
            ('\\ArrayIterator' === $collection->getIteratorClass()));
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::setIteratorClass
     * @covers \DCarbone\AbstractCollectionPlus::getIteratorClass
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testCanSetValidIteratorClassWithoutLeadingSlashes()
    {
        $collection = new \DCarbone\CollectionPlus();
        $collection->setIteratorClass('ArrayIterator');

        $this->assertTrue(
            ('\\ArrayIterator' === $collection->getIteratorClass()));
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::setIteratorClass
     * @uses \DCarbone\AbstractCollectionPlus
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionThrownWhenUndefinedIteratorClassSet()
    {
        $collection = new \DCarbone\CollectionPlus();
        $collection->setIteratorClass('\\MyAwesomeIterator');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::getIterator
     * @uses \DCarbone\AbstractCollectionPlus
     * @uses \ArrayIterator
     */
    public function testCanGetDefaultIteratorClass()
    {
        $collection = new \DCarbone\CollectionPlus(
            array('key1' => 'value1', 'key2' => 'value2'));

        $arrayIterator = $collection->getIterator();

        $this->assertInstanceOf('\\ArrayIterator', $arrayIterator);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::setIteratorClass
     * @covers \DCarbone\AbstractCollectionPlus::getIterator
     * @uses \DCarbone\AbstractCollectionPlus
     * @uses \MySuperAwesomeIteratorClass
     */
    public function testCanGetCustomIteratorClass()
    {
        $collection = new \DCarbone\CollectionPlus(
            array('key1' => 'value1', 'key2' => 'value2'));

        $collection->setIteratorClass('\\MySuperAwesomeIteratorClass');

        $arrayIterator = $collection->getIterator();

        $this->assertInstanceOf('\\MySuperAwesomeIteratorClass', $arrayIterator);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::map
     * @uses \DCarbone\AbstractCollectionPlus
     * @expectedException \InvalidArgumentException
     */
    public function testMapThrowsExceptionWhenUncallableFuncPassed()
    {
        $collection = new \DCarbone\CollectionPlus();
        $collection->map('this_function_doesnt_exist');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::map
     * @covers \DCarbone\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\AbstractCollectionPlus::initNew
     * @covers \DCarbone\AbstractCollectionPlus::count
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testMapWithGlobalFunction()
    {
        $collection = new \DCarbone\CollectionPlus();
        for($i = 0; $i < 10; $i++)
            $collection[] = $i;

        $this->assertEquals(10, count($collection));

        $mapped = $collection->map('_collection_map_change_odd_values_to_null');
        $this->assertEquals(10, count($mapped));

        $this->assertNull($mapped[1]);
        $this->assertNotNull($mapped[0]);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::map
     * @covers \DCarbone\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\AbstractCollectionPlus::initNew
     * @covers \DCarbone\AbstractCollectionPlus::count
     * @uses \DCarbone\AbstractCollectionPlus
     * @uses CollectionPlusTests
     */
    public function testMapWithObjectStaticMethod()
    {
        $collection = new \DCarbone\CollectionPlus();
        for($i = 0; $i < 10; $i++)
            $collection[] = $i;

        $this->assertEquals(10, count($collection));

        $mapped = $collection->map(array('CollectionPlusTests', '_collection_map_change_odd_values_to_null'));
        $this->assertEquals(10, count($mapped));

        $this->assertNull($mapped[1]);
        $this->assertNotNull($mapped[0]);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::map
     * @covers \DCarbone\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\AbstractCollectionPlus::initNew
     * @covers \DCarbone\AbstractCollectionPlus::count
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testMapWithAnonymousFunction()
    {
        $collection = new \DCarbone\CollectionPlus();
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
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::map
     * @covers \DCarbone\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\AbstractCollectionPlus::initNew
     * @covers \DCarbone\AbstractCollectionPlus::count
     * @uses \DCarbone\AbstractCollectionPlus
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
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::filter
     * @covers \DCarbone\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\AbstractCollectionPlus::initNew
     * @covers \DCarbone\AbstractCollectionPlus::count
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testFilterWithNoCallableParameter()
    {
        $collection = new \DCarbone\CollectionPlus();
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
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::filter
     * @covers \DCarbone\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\AbstractCollectionPlus::initNew
     * @covers \DCarbone\AbstractCollectionPlus::count
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testFilterWithGlobalFunction()
    {
        $collection = new \DCarbone\CollectionPlus();
        for($i = 1; $i <= 10; $i++)
        {
            if ($i % 2 === 0)
                $collection[] = true;
            else
                $collection[] = false;
        }

        $this->assertEquals(10, count($collection));

        $filtered = $collection->filter('_collection_filter_remove_true_values');
        $this->assertEquals(5, count($filtered));
        $this->assertNotContains(true, $filtered);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::filter
     * @covers \DCarbone\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\AbstractCollectionPlus::initNew
     * @covers \DCarbone\AbstractCollectionPlus::count
     * @uses \DCarbone\AbstractCollectionPlus
     * @uses \CollectionPlusTests
     */
    public function testFilterWithObjectStaticFunction()
    {
        $collection = new \DCarbone\CollectionPlus();
        for($i = 1; $i <= 10; $i++)
        {
            if ($i % 2 === 0)
                $collection[] = true;
            else
                $collection[] = false;
        }

        $this->assertEquals(10, count($collection));

        $filtered = $collection->filter(array('CollectionPlusTests', '_collection_filter_remove_true_values'));
        $this->assertEquals(5, count($filtered));
        $this->assertNotContains(true, $filtered);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::filter
     * @covers \DCarbone\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\AbstractCollectionPlus::initNew
     * @covers \DCarbone\AbstractCollectionPlus::count
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testFilterWithAnonymousFunction()
    {
        $collection = new \DCarbone\CollectionPlus();
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
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::filter
     * @covers \DCarbone\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\AbstractCollectionPlus::initNew
     * @covers \DCarbone\AbstractCollectionPlus::count
     * @uses \DCarbone\AbstractCollectionPlus
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

    /**
     * @covers \DCarbone\AbstractCollectionPlus::filter
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionThrownWhenUnCallableFunctionPassedToFilter()
    {
        $collection = new \DCarbone\CollectionPlus(array(false, null, true));
        $collection->filter('haha, i\'m not a function!');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::sort
     * @covers \DCarbone\AbstractCollectionPlus::first
     * @covers \DCarbone\AbstractCollectionPlus::last
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testSort()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'z', 'q', 'a', 'b',
        ));

        $collection->sort();
        $this->assertTrue(
            ($collection->first() === 'a'),
            'First value expected to be "a", saw "'.$collection->first().'"');

        $this->assertTrue(
            ($collection->last() === 'z'),
            'Last value expected to be "z", saw "'.$collection->last().'"');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::rsort
     * @covers \DCarbone\AbstractCollectionPlus::first
     * @covers \DCarbone\AbstractCollectionPlus::last
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testRSort()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'z', 'q', 'a', 'b',
        ));

        $collection->rsort();
        $this->assertTrue(
            ($collection->first() === 'z'),
            'First value expected to be "z", saw "'.$collection->first().'"');

        $this->assertTrue(
            ($collection->last() === 'a'),
            'Last value expected to be "a", saw "'.$collection->last().'"');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::usort
     * @covers \DCarbone\AbstractCollectionPlus::first
     * @covers \DCarbone\AbstractCollectionPlus::last
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testUSortWithAnonymousFunction()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'z', 'q', 'a', 'b',
        ));

        $collection->usort(function($a, $b) {
            return ($a > $b ? 1 : -1);
        });

        $this->assertTrue(
            ($collection->first() === 'a'),
            'First value expected to be "a", saw "'.$collection->first().'"');
        $this->assertTrue(
            ($collection->last() === 'z'),
            'Last value expected to be "a", saw "'.$collection->last().'"');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::ksort
     * @covers \DCarbone\AbstractCollectionPlus::getFirstKey
     * @covers \DCarbone\AbstractCollectionPlus::getLastKey
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testKSort()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'z' => 'z',
            'q' => 'q',
            'a' => 'a',
            'b' => 'b',
        ));

        $collection->ksort();
        $this->assertTrue(
            ($collection->getFirstKey() === 'a'),
            'First key expected to be "a", saw "'.$collection->getFirstKey().'"');

        $this->assertTrue(
            ($collection->getLastKey() === 'z'),
            'Last key expected to be "z", saw "'.$collection->getLastKey().'"');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::krsort
     * @covers \DCarbone\AbstractCollectionPlus::getFirstKey
     * @covers \DCarbone\AbstractCollectionPlus::getLastKey
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testKRSort()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'z' => 'z',
            'q' => 'q',
            'a' => 'a',
            'b' => 'b',
        ));

        $collection->krsort();
        $this->assertTrue(
            ($collection->getFirstKey() === 'z'),
            'First key expected to be "z", saw "'.$collection->getFirstKey().'"');

        $this->assertTrue(
            ($collection->getLastKey() === 'a'),
            'Last key expected to be "a", saw "'.$collection->getLastKey().'"');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::uksort
     * @covers \DCarbone\AbstractCollectionPlus::getFirstKey
     * @covers \DCarbone\AbstractCollectionPlus::getLastKey
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testUKSort()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'z' => 'z',
            'q' => 'q',
            'a' => 'a',
            'b' => 'b',
        ));

        $collection->uksort(function($a, $b) {
            return ($a > $b ? 1 : -1);
        });
        $this->assertTrue(
            ($collection->getFirstKey() === 'a'),
            'First key expected to be "a", saw "'.$collection->getFirstKey().'"');

        $this->assertTrue(
            ($collection->getLastKey() === 'z'),
            'Last key expected to be "z", saw "'.$collection->getLastKey().'"');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::asort
     * @covers \DCarbone\AbstractCollectionPlus::first
     * @covers \DCarbone\AbstractCollectionPlus::last
     * @covers \DCarbone\AbstractCollectionPlus::getFirstKey
     * @covers \DCarbone\AbstractCollectionPlus::getLastKey
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testASort()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'z' => 'z',
            'q' => 'q',
            'a' => 'a',
            'b' => 'b',
        ));

        $collection->asort();

        $this->assertTrue(
            ($collection->first() === 'a'),
            'First value expected to be "a", saw "'.$collection->first().'"');
        $this->assertTrue(
            ($collection->getFirstKey() === 'a'),
            'First key expected to be "a", saw "'.$collection->getFirstKey().'"');

        $this->assertTrue(
            ($collection->last() === 'z'),
            'Last value expected to be "z", saw "'.$collection->last().'"');
        $this->assertTrue(
            ($collection->getLastKey() === 'z'),
            'Last key expected to be "z", saw "'.$collection->getLastKey().'"');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::arsort
     * @covers \DCarbone\AbstractCollectionPlus::first
     * @covers \DCarbone\AbstractCollectionPlus::last
     * @covers \DCarbone\AbstractCollectionPlus::getFirstKey
     * @covers \DCarbone\AbstractCollectionPlus::getLastKey
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testARSort()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'z' => 'z',
            'q' => 'q',
            'a' => 'a',
            'b' => 'b',
        ));

        $collection->arsort();

        $this->assertTrue(
            ($collection->first() === 'z'),
            'First value expected to be "z", saw "'.$collection->first().'"');
        $this->assertTrue(
            ($collection->getFirstKey() === 'z'),
            'First key expected to be "z", saw "'.$collection->getFirstKey().'"');

        $this->assertTrue(
            ($collection->last() === 'a'),
            'Last value expected to be "a", saw "'.$collection->last().'"');
        $this->assertTrue(
            ($collection->getLastKey() === 'a'),
            'Last key expected to be "a", saw "'.$collection->getLastKey().'"');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::uasort
     * @covers \DCarbone\AbstractCollectionPlus::first
     * @covers \DCarbone\AbstractCollectionPlus::last
     * @covers \DCarbone\AbstractCollectionPlus::getFirstKey
     * @covers \DCarbone\AbstractCollectionPlus::getLastKey
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testUASort()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'z' => 'z',
            'q' => 'q',
            'a' => 'a',
            'b' => 'b',
        ));

        $collection->uasort(function($a, $b) {
            return ($a > $b ? 1 : -1);
        });

        $this->assertTrue(
            ($collection->first() === 'a'),
            'First value expected to be "a", saw "'.$collection->first().'"');
        $this->assertTrue(
            ($collection->getFirstKey() === 'a'),
            'First key expected to be "a", saw "'.$collection->getFirstKey().'"');

        $this->assertTrue(
            ($collection->last() === 'z'),
            'Last value expected to be "z", saw "'.$collection->last().'"');
        $this->assertTrue(
            ($collection->getLastKey() === 'z'),
            'Last key expected to be "z", saw "'.$collection->getLastKey().'"');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::current
     * @covers \DCarbone\AbstractCollectionPlus::next
     * @covers \DCarbone\AbstractCollectionPlus::key
     * @covers \DCarbone\AbstractCollectionPlus::valid
     * @covers \DCarbone\AbstractCollectionPlus::rewind
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testIteratorImplementation()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3'
        ));

        $this->assertInstanceOf('\\Iterator', $collection);

        foreach(array('current', 'key', 'valid', 'rewind', 'next') as $method)
            $this->assertTrue(
                method_exists($collection, $method),
                'Method "'.$method.'" not defined');

        $this->assertTrue(
            ($collection->current() === 'value1'),
            '::current() returned incorrect value');

        $this->assertTrue(
            ($collection->key() === 'key1'),
            '::key() returned incorrect value');

        $this->assertTrue(
            $collection->valid(),
            '::valid() returned false');

        $collection->next();
        $this->assertTrue(
            ($collection->current() === 'value2'),
            '::next() did not move internal pointer correctly');
        $this->assertTrue(
            ($collection->key() === 'key2'),
            '::next did not move the internal pointer correctly');

        $collection->rewind();
        $this->assertTrue(
            ($collection->current() === 'value1'),
            '::rewind did not reset internal pointer correctly');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::current
     * @covers \DCarbone\AbstractCollectionPlus::next
     * @covers \DCarbone\AbstractCollectionPlus::key
     * @covers \DCarbone\AbstractCollectionPlus::valid
     * @covers \DCarbone\AbstractCollectionPlus::rewind
     * @covers \DCarbone\AbstractCollectionPlus::hasChildren
     * @covers \DCarbone\AbstractCollectionPlus::getChildren
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testRecursiveIteratorImplementation()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'key1' => array('value1'),
            'key2' => 'value2',
            'key3' => array('value3'),
        ));

        $this->assertInstanceOf('\\RecursiveIterator', $collection);

        $this->assertTrue(
            method_exists($collection, 'hasChildren'),
            'Method "hasChildren" not found');
        $this->assertTrue(
            method_exists($collection, 'getChildren'),
            'Method "getChildren" not found');

        $this->assertTrue(
            $collection->hasChildren(),
            '::hasChildren returned false, first element should be array');

        $collection->next();
        $this->assertFalse(
            $collection->hasChildren(),
            '::hasChildren returned true, second element should be string');

        $collection->next();
        $this->assertTrue(
            $collection->hasChildren(),
            '::hasChildren returned false, third element should be array');

        $collection->rewind();

        $array = $collection->getChildren();
        $this->assertTrue(
            is_array($array),
            '::getChildren did not return array');

        $this->assertContains('value1', $array);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @covers \DCarbone\AbstractCollectionPlus::seek
     * @covers \DCarbone\AbstractCollectionPlus::current
     * @covers \DCarbone\AbstractCollectionPlus::valid
     * @covers \DCarbone\AbstractCollectionPlus::key
     * @covers \DCarbone\AbstractCollectionPlus::next
     * @covers \DCarbone\AbstractCollectionPlus::offsetGet
     * @uses \DCarbone\AbstractCollectionPlus
     */
    public function testSeekableIteratorImplementationWithValidPosition()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'key1' => array('value1'),
            'key2' => 'value2',
            'key3' => array('value3'),
        ));

        $this->assertInstanceOf('\\SeekableIterator', $collection);

        $this->assertTrue(
            method_exists($collection, 'seek'),
            'Method "seek" not found');

        $this->assertTrue($collection['key1'] === array('value1'));

        $collection->seek('key2');
        $this->assertTrue(
            ($collection->key() === 'key2'),
            '::seek did not move the internal pointer correctly');
        $this->assertTrue(
            ($collection->current() === 'value2'),
            '::seek did not move the internal pointer correctly');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::seek
     * @expectedException \OutOfBoundsException
     */
    public function testSeekableIteratorThrowExceptionWithInvalidPosition()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'key1' => array('value1'),
            'key2' => 'value2',
            'key3' => array('value3'),
        ));

        $this->assertInstanceOf('\\SeekableIterator', $collection);

        $this->assertTrue(
            method_exists($collection, 'seek'),
            'Method "seek" not found');

        $this->assertTrue($collection['key1'] === array('value1'));

        $collection->seek('sandwiches');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::values
     */
    public function testCanGetValuesAsArray()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'key1' => array('value1'),
            'key2' => 'value2',
            'key3' => array('value3'),
            'value4',
        ));

        $values = $collection->values();
        $this->assertInternalType('array', $values);
        $this->assertCount(4, $collection);
        $this->assertContains(array('value1'), $values);
        $this->assertContains('value2', $values);
        $this->assertContains(array('value3'), $values);
        $this->assertContains('value4', $values);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::values
     */
    public function testCanGetEmptyValuesArrayFromEmptyCollection()
    {
        $collection = new \DCarbone\CollectionPlus();
        $values = $collection->values();
        $this->assertInternalType('array', $values);
        $this->assertCount(0, $values);
    }
}