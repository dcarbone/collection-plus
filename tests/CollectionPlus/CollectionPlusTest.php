<?php

date_default_timezone_set('UTC');

require_once __DIR__.'/../misc/functions.php';
require_once __DIR__.'/../misc/classes.php';

/**
 * Class CollectionPlusTest
 */
class CollectionPlusTest extends \PHPUnit_Framework_TestCase
{
    /** @var bool */
    protected $gt540;

    /**
     * Determine if we're in a PHP env greater than 5.4.0
     */
    protected function setUp()
    {
        $this->gt540 = version_compare(PHP_VERSION, '5.4.0', 'ge') === -1;
    }

    //<editor-fold desc="ConstructorTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @return \DCarbone\AbstractCollectionPlus
     */
    public function testCanConstructObjectWithNoArguments()
    {
        $collection = new \DCarbone\CollectionPlus();
        $this->assertInstanceOf('\\DCarbone\\AbstractCollectionPlus', $collection);

        return $collection;
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__construct
     * @return \DCarbone\AbstractCollectionPlus
     */
    public function testCanConstructObjectWithArrayParameter()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'value0',
            'value1',
            'key2' => 'value2',
            4 => 'value3',
            '3' => 4,
        ));
        $this->assertInstanceOf('\\DCarbone\\AbstractCollectionPlus', $collection);

        return $collection;
    }
    //</editor-fold>

    //<editor-fold desc="DoesImplementTests">
    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testObjectImplementsArrayAccess(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertInstanceOf('\\ArrayAccess', $collection);
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testObjectImplementsSeekableIterator(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertInstanceOf('\\SeekableIterator', $collection);
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testObjectImplementsCountable(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertInstanceOf('\\Countable', $collection);
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testObjectImplementsFirstLastValueKeyMethods(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertTrue(is_callable(array($collection, 'firstValue'), false), 'firstValue method not callable');
        $this->assertTrue(is_callable(array($collection, 'lastValue'), false), 'lastValue method not callable');
        $this->assertTrue(is_callable(array($collection, 'firstKey'), false), 'firstKey method not callable');
        $this->assertTrue(is_callable(array($collection, 'lastKey'), false), 'lastKey method not callable');
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testObjectImplementsIsEmptyMethod(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertTrue(is_callable(array($collection, 'isEmpty')), 'isEmpty method not callable');
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testObjectImplementsEndMethod(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertTrue(is_callable(array($collection, 'end'), false), 'end method not callable');
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testObjectImplementsKeysMethod(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertTrue(is_callable(array($collection, 'keys'), false), 'keys method not callable');
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testObjectImplementsValuesMethod(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertTrue(is_callable(array($collection, 'values'), false), 'values method not callable');
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testObjectImplementsSearchMethod(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertTrue(is_callable(array($collection, 'search'), false), 'search method not callable');
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testObjectImplementsSerializable(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertInstanceOf('\\Serializable', $collection);
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testObjectImplementsJsonSerializable(\DCarbone\AbstractCollectionPlus $collection)
    {
        if ($this->gt540)
            $this->assertInstanceOf('\\JsonSerializable', $collection);
        else
            $this->assertInstanceOf('\\DCarbone\\JsonSerializable', $collection);
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testObjectImplementsSetMethod(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertTrue(is_callable(array($collection, 'set'), false), 'set method not callable');
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testObjectImplementsAppendMethod(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertTrue(is_callable(array($collection, 'append'), false), 'append method not callable');
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testObjectImplementContainsMethod(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertTrue(is_callable(array($collection, 'contains'), false), 'contains method not callable');
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testObjectImplementsRemoveMethod(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertTrue(is_callable(array($collection, 'remove'), false), 'remove method not callable');
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testObjectImplementsRemoveElementMethod(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertTrue(is_callable(array($collection, 'removeElement'), false), 'removeElement method not callable');
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testObjectImplementsExistsMethod(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertTrue(is_callable(array($collection, 'exists'), false), 'exists method is not callable');
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collectionPlus
     */
    public function testObjectImplementsFilterMethod(\DCarbone\AbstractCollectionPlus $collectionPlus)
    {
        $this->assertTrue(is_callable(array($collectionPlus, 'filter'), false), 'filter method is not callable');
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testCanSetAndGetCustomIteratorClass(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertTrue(is_callable(array($collection, 'setIteratorClass'), false), 'setIteratorClass method not callable');
        $this->assertTrue(is_callable(array($collection, 'getIteratorClass'), false), 'getIteratorClass method not callable');
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testObjectImplementsGetIteratorMethod(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertTrue(is_callable(array($collection, 'getIterator'), false), 'getIterator method not callable');
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collectionPlus
     */
    public function testObjectImplementsMapMethod(\DCarbone\AbstractCollectionPlus $collectionPlus)
    {
        $this->assertTrue(is_callable(array($collectionPlus, 'map'), false), 'map method not callable');
    }

    /**
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testObjectImplementsRecursiveIterator(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertInstanceOf('\\RecursiveIterator', $collection);
    }
    //</editor-fold>

    //<editor-fold desc="ArrayAccessTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::offsetExists
     * @covers \DCarbone\AbstractCollectionPlus::offsetGet
     * @covers \DCarbone\AbstractCollectionPlus::offsetSet
     * @covers \DCarbone\AbstractCollectionPlus::offsetUnset
     * @depends testObjectImplementsArrayAccess
     */
    public function testBasicArrayAccessImplementation()
    {
        $collection = new \DCarbone\CollectionPlus();

        $this->assertFalse(isset($collection['key1']));
        $collection[] = 'value';
        $this->assertTrue(isset($collection[0]));
        $this->assertEquals('value', $collection[0]);
        unset($collection[0]);
        $this->assertNotContains('value', $collection);
        $collection['key'] = 'value';
        $this->assertArrayHasKey('key', $collection);
        $this->assertContains('value', $collection);
        unset($collection['key']);
        $this->assertArrayNotHasKey('key', $collection);
        $this->assertNotContains('value', $collection);
        $collection[] = null;
        $this->assertTrue($collection->offsetExists(1));
        $this->assertContains(null, $collection);
    }
    //</editor-fold>

    //<editor-fold desc="CountableTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::count
     * @depends testObjectImplementsCountable
     */
    public function testCountableImplementation()
    {
        $collection = new \DCarbone\CollectionPlus();

        $this->assertCount(0, $collection);
        $collection[] = 'value';
        $this->assertCount(1, $collection);
    }
    //</editor-fold>

    //<editor-fold desc="SeekableIteratorTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::current
     * @covers \DCarbone\AbstractCollectionPlus::next
     * @covers \DCarbone\AbstractCollectionPlus::key
     * @covers \DCarbone\AbstractCollectionPlus::valid
     * @covers \DCarbone\AbstractCollectionPlus::rewind
     * @covers \DCarbone\AbstractCollectionPlus::seek
     * @depends testObjectImplementsSeekableIterator
     */
    public function testSeekableIteratorImplementation()
    {
        $collection = new \DCarbone\CollectionPlus();

        $this->assertFalse($collection->valid());
        $this->assertFalse($collection->current());
        $this->assertNull($collection->key());

        $collection[] = 'value0';
        $collection[] = 'value1';
        $collection[] = 'value2';
        $collection['key3'] = 'value3';

        $this->assertTrue($collection->valid());
        $this->assertEquals('value0', $collection->current());
        $this->assertEquals(0, $collection->key());

        $collection->seek('key3');
        $this->assertTrue($collection->valid());
        $this->assertEquals('value3', $collection->current());
        $this->assertEquals('key3', $collection->key());

        $collection->seek(2);
        $this->assertTrue($collection->valid());
        $this->assertEquals('value2', $collection->current());
        $this->assertEquals(2, $collection->key());

        $collection->rewind();
        $this->assertTrue($collection->valid());
        $this->assertEquals('value0', $collection->current());
        $this->assertEquals(0, $collection->key());

        $collection->next();
        $this->assertTrue($collection->valid());
        $this->assertEquals('value1', $collection->current());
        $this->assertEquals(1, $collection->key());
    }
    //</editor-fold>

    //<editor-fold desc="IsEmptyMethodTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::isEmpty
     * @depends testObjectImplementsIsEmptyMethod
     */
    public function testIsEmptyMethodOnPopulatedObject()
    {
        $collection = new \DCarbone\CollectionPlus(array('value'));
        $this->assertFalse($collection->isEmpty());
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::isEmpty
     * @depends testObjectImplementsIsEmptyMethod
     */
    public function testIsEmptyMethodOnEmptyObject()
    {
        $collection = new \DCarbone\CollectionPlus();
        $this->assertTrue($collection->isEmpty());
    }
    //</editor-fold>

    //<editor-fold desc="FirstLastValueMethodsTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::firstValue
     * @covers \DCarbone\AbstractCollectionPlus::lastValue
     * @covers \DCarbone\AbstractCollectionPlus::_updateFirstLastKeys
     * @depends testObjectImplementsIsEmptyMethod
     * @depends testObjectImplementsFirstLastValueKeyMethods
     */
    public function testFirstLastValueMethodsOnPopulatedObject()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'first',
            'middle',
            7 => 'last'
        ));

        $first = $collection->firstValue();
        $this->assertEquals('first', $first);
        $last = $collection->lastValue();
        $this->assertEquals('last', $last);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::firstValue
     * @covers \DCarbone\AbstractCollectionPlus::lastValue
     * @covers \DCarbone\AbstractCollectionPlus::_updateFirstLastKeys
     * @depends testObjectImplementsIsEmptyMethod
     * @depends testObjectImplementsFirstLastValueKeyMethods
     */
    public function testFirstLastValueMethodsOnEmptyObject()
    {
        $collection = new \DCarbone\CollectionPlus();

        $first = $collection->firstValue();
        $this->assertNull($first);
        $last = $collection->lastValue();
        $this->assertNull($last);
    }
    //</editor-fold>

    //<editor-fold desc="FirstLastKeyMethodsTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::firstKey
     * @covers \DCarbone\AbstractCollectionPlus::lastKey
     * @covers \DCarbone\AbstractCollectionPlus::_updateFirstLastKeys
     * @depends testObjectImplementsIsEmptyMethod
     * @depends testObjectImplementsFirstLastValueKeyMethods
     */
    public function testFirstLastKeyMethodsOnPopulatedObject()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'first',
            'middle',
            7 => 'last',
        ));

        $first = $collection->firstKey();
        $this->assertEquals(0, $first);
        $last = $collection->lastKey();
        $this->assertEquals(7, $last);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::firstKey
     * @covers \DCarbone\AbstractCollectionPlus::lastKey
     * @covers \DCarbone\AbstractCollectionPlus::_updateFirstLastKeys
     * @depends testObjectImplementsIsEmptyMethod
     * @depends testObjectImplementsFirstLastValueKeyMethods
     */
    public function testFirstLastKeyMethodsOnEmptyObject()
    {
        $collection = new \DCarbone\CollectionPlus();

        $first = $collection->firstKey();
        $this->assertNull($first);
        $last = $collection->lastKey();
        $this->assertNull($last);
    }
    //</editor-fold>

    //<editor-fold desc="endMethodTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::end
     * @depends testCanConstructObjectWithNoArguments
     * @depends testObjectImplementsEndMethod
     * @depends testSeekableIteratorImplementation
     * @depends testFirstLastKeyMethodsOnEmptyObject
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testEndMethodOnEmptyObject(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertFalse($collection->valid());
        $collection->end();
        $this->assertFalse($collection->valid());
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::end
     * @depends testCanConstructObjectWithArrayParameter
     * @depends testObjectImplementsEndMethod
     * @depends testSeekableIteratorImplementation
     * @depends testFirstLastKeyMethodsOnPopulatedObject
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testEndMethodOnPopulatedObject(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertTrue($collection->valid());
        $this->assertEquals('value0', $collection->current());
        $this->assertEquals(0, $collection->key());

        $collection->end();
        $this->assertTrue($collection->valid());
        $this->assertEquals(4, $collection->current());
        $this->assertEquals('3', $collection->key());
    }
    //</editor-fold>

    //<editor-fold desc="keysMethodTests">
    /**
     * @covers  \DCarbone\AbstractCollectionPlus::keys
     * @depends testCanConstructObjectWithArrayParameter
     * @depends testObjectImplementsKeysMethod
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testKeysMethodOnPopulatedObject(\DCarbone\AbstractCollectionPlus $collection)
    {
        $keys = $collection->keys();
        $this->assertInternalType('array', $keys);
        $this->assertCount(5, $keys);
        $this->assertContains(4, $keys);
        $this->assertContains('key2', $keys);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::keys
     * @depends testCanConstructObjectWithNoArguments
     * @depends testObjectImplementsKeysMethod
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testKeysMethodOnEmptyObject(\DCarbone\AbstractCollectionPlus $collection)
    {
        $keys = $collection->keys();
        $this->assertInternalType('array', $keys);
        $this->assertCount(0, $keys);
    }
    //</editor-fold>

    //<editor-fold desc="valuesMethodTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::values
     * @depends testCanConstructObjectWithArrayParameter
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testValuesMethodOnPopulatedObject(\DCarbone\AbstractCollectionPlus $collection)
    {
        $values = $collection->values();
        $this->assertInternalType('array', $values);
        $this->assertCount(5, $values);
        $this->assertContains('value1', $values);
        $this->assertContains('value3', $values);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::values
     * @depends testCanConstructObjectWithNoArguments
     * @depends testObjectImplementsValuesMethod
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testValuesMethodOnEmptyObject(\DCarbone\AbstractCollectionPlus $collection)
    {
        $values = $collection->values();
        $this->assertInternalType('array', $values);
        $this->assertCount(0, $values);
    }
    //</editor-fold>

    //<editor-fold desc="searchMethodTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::search
     * @depends testCanConstructObjectWithNoArguments
     * @depends testObjectImplementsSearchMethod
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testLooseSearchOnEmptyObject(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertFalse($collection->search('sandwiches'));
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::search
     * @depends testCanConstructObjectWithArrayParameter
     * @depends testObjectImplementsSearchMethod
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testLooseSearchOnPopulatedObject(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertEquals('3', $collection->search('4'));
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::search
     * @depends testCanConstructObjectWithNoArguments
     * @depends testObjectImplementsSearchMethod
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testStrictSearchOnEmptyObject(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertFalse($collection->search('4', true));
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::search
     * @depends testCanConstructObjectWithArrayParameter
     * @depends testObjectImplementsSearchMethod
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testStrictSearchOnPopulatedObject(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertFalse($collection->search('4', true));
    }
    //</editor-fold>

    //<editor-fold desc="__get__setMethodTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::__set
     * @depends testCanConstructObjectWithNoArguments
     * @depends testBasicArrayAccessImplementation
     * @return \DCarbone\AbstractCollectionPlus
     */
    public function test__SetMethod()
    {
        $collection = new \DCarbone\CollectionPlus();

        $collection->key0 = 'value0';
        $collection->OtherKey = 'OtherValue';
        $collection->{'key with space'} = 'value with space';
        $collection->{0} = 'integer key';

        $this->assertTrue(isset($collection['key0']));
        $this->assertTrue(isset($collection['OtherKey']));
        $this->assertTrue(isset($collection['key with space']));
        $this->assertTrue(isset($collection[0]));

        $this->assertEquals('value0', $collection['key0']);
        $this->assertEquals('OtherValue', $collection['OtherKey']);
        $this->assertEquals('value with space', $collection['key with space']);
        $this->assertEquals('integer key', $collection[0]);

        return $collection;
    }

    /**
     * @covers  \DCarbone\AbstractCollectionPlus::__get
     * @depends test__SetMethod
     * @param \DCarbone\AbstractCollectionPlus $collection
     * @return \DCarbone\AbstractCollectionPlus
     */
    public function test__GetMethod(\DCarbone\AbstractCollectionPlus $collection)
    {
        $this->assertEquals('value0', $collection->key0);
        $this->assertEquals('OtherValue', $collection->OtherKey);
        $this->assertEquals('value with space', $collection->{'key with space'});
        $this->assertEquals('integer key', $collection->{0});

        return $collection;
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__get
     * @depends test__GetMethod
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testModifyingValuesWith__GetMethod(\DCarbone\AbstractCollectionPlus $collection)
    {
        $collection->key0 = new \stdClass();
        $this->assertInternalType('object', $collection->key0);

        $collection->key0->key1 = 'value1';
        $this->assertEquals('value1', $collection->key0->key1);

        $collection->key0 = array('value0');
        $collection->key0[] = 'value1';
        $this->assertEquals('value1', end($collection->key0));
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::__get
     * @depends testCanConstructObjectWithArrayParameter
     * @depends test__GetMethod
     * @expectedException \OutOfBoundsException
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testExceptionThrownWhenGettingInvalidProperty(\DCarbone\AbstractCollectionPlus $collection)
    {
        $collection->sandwiches;
    }
    //</editor-fold>

    //<editor-fold desc="getArrayCopyMethodTest">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::getArrayCopy
     * @depends testCanConstructObjectWithArrayParameter
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testGetArrayCopy(\DCarbone\AbstractCollectionPlus $collection)
    {
        $copy = $collection->getArrayCopy();
        $this->assertInternalType('array', $copy);
        $this->assertSameSize($collection, $copy);
    }
    //</editor-fold>

    //<editor-fold desc="SerializationMethodTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::serialize
     * @depends testCanConstructObjectWithNoArguments
     * @depends testObjectImplementsSerializable
     * @param \DCarbone\AbstractCollectionPlus $collection
     * @return string
     */
    public function testCanSerializeEmptyObject(\DCarbone\AbstractCollectionPlus $collection)
    {
        $serialized = serialize($collection);
        $this->assertInternalType('string', $serialized);
        $this->assertEquals('C:23:"DCarbone\CollectionPlus":6:{a:0:{}}', $serialized);
        return $serialized;
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::serialize
     * @depends testCanConstructObjectWithArrayParameter
     * @depends testObjectImplementsSerializable
     * @param \DCarbone\AbstractCollectionPlus $collection
     * @return string
     */
    public function testCanSerializePopulatedObject(\DCarbone\AbstractCollectionPlus $collection)
    {
        $serialized = serialize($collection);
        $this->assertInternalType('string', $serialized);
        $this->assertEquals(
            'C:23:"DCarbone\CollectionPlus":89:{a:5:{i:0;s:6:"value0";i:1;s:6:"value1";s:4:"key2";s:6:"value2";i:4;s:6:"value3";i:3;i:4;}}',
            $serialized);
        return $serialized;
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::unserialize
     * @depends testCanSerializeEmptyObject
     * @depends testCountableImplementation
     * @param string $serialized
     */
    public function testCanUnserializeEmptyObject($serialized)
    {
        $collection = unserialize($serialized);
        $this->assertInstanceOf('\\DCarbone\\AbstractCollectionPlus', $collection);
        $this->assertCount(0, $collection);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::unserialize
     * @depends testCanSerializePopulatedObject
     * @depends testCountableImplementation
     * @depends testBasicArrayAccessImplementation
     * @param string $serialized
     */
    public function testCanUnserializePopulatedObject($serialized)
    {
        $collection = unserialize($serialized);
        $this->assertInstanceOf('\\DCarbone\\AbstractCollectionPlus', $collection);
        $this->assertCount(5, $collection);
        $this->assertContains('value0', $collection);
        $this->assertContains(4, $collection);
    }
    //</editor-fold>

    //<editor-fold desc="jsonSerializeTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::jsonSerialize
     * @depends testCanConstructObjectWithNoArguments
     * @param \DCarbone\AbstractCollectionPlus $collection
     * @return string
     */
    public function testCanJsonEncodeEmptyObject(\DCarbone\AbstractCollectionPlus $collection)
    {
        if ($this->gt540)
            $json = json_encode($collection);
        else
            $json = json_encode($collection->jsonSerialize());

        return $json;
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::jsonSerialize
     * @depends testCanConstructObjectWithArrayParameter
     * @param \DCarbone\AbstractCollectionPlus $collection
     * @return string
     */
    public function testCanJsonEncodePopulatedObject(\DCarbone\AbstractCollectionPlus $collection)
    {
        if ($this->gt540)
            $json = json_encode($collection);
        else
            $json = json_encode($collection->jsonSerialize());

        return $json;
    }

    /**
     * @depends testCanJsonEncodeEmptyObject
     * @param string $json
     */
    public function testCanCreateArrayFromEmptyCollectionJsonString($json)
    {
        $array = json_decode($json, true);
        $this->assertInternalType('array', $array);
        $this->assertCount(0, $array);
    }

    /**
     * @depends testCanJsonEncodePopulatedObject
     * @param string $json
     */
    public function testCanCreateArrayFromPopulatedCollectionJsonString($json)
    {
        $array = json_decode($json, true);
        $this->assertInternalType('array', $array);
        $this->assertCount(5, $array);
    }
    //</editor-fold>

    //<editor-fold desc="toStringMethodTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::__toString
     * @depends testCanConstructObjectWithArrayParameter
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testCollectionCanBeTypecastAsString(\DCarbone\AbstractCollectionPlus $collection)
    {
        $string = (string)$collection;
        $this->assertTrue(is_string($string));
    }
    //</editor-fold>

    //<editor-fold desc="exchangeArrayMethodTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::exchangeArray
     * @depends testCanConstructObjectWithArrayParameter
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
     * @covers \DCarbone\AbstractCollectionPlus::exchangeArray
     * @depends testCanConstructObjectWithArrayParameter
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
     * @covers \DCarbone\AbstractCollectionPlus::exchangeArray
     * @depends testCanConstructObjectWithArrayParameter
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
     * @depends testCanConstructObjectWithArrayParameter
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
     * @depends testCanConstructObjectWithNoArguments
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
     * @depends testCanConstructObjectWithNoArguments
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionIsRaisedWhenNonArrayOrObjectPassedToExchangeArray()
    {
        $collection = new \DCarbone\CollectionPlus();
        $newData = 42;
        $collection->exchangeArray($newData);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::exchangeArray
     * @depends testCanConstructObjectWithNoArguments
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionThrownWhenInvalidObjectPassedToExchangeArray()
    {
        $collection = new \DCarbone\CollectionPlus();
        $class = new im_just_a_class();
        $collection->exchangeArray($class);
    }
    //</editor-fold>

    //<editor-fold desc="SetAppendMethodTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::set
     * @depends testObjectImplementsSetMethod
     * @depends testBasicArrayAccessImplementation
     */
    public function testSetMethodImplementation()
    {
        $collection = new \DCarbone\CollectionPlus();
        $collection->set('key1', 'value1');
        $this->assertArrayHasKey('key1', $collection);
        $this->assertEquals('value1', $collection['key1']);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::append
     * @depends testObjectImplementsAppendMethod
     * @depends testBasicArrayAccessImplementation
     */
    public function testAppendMethodImplementation()
    {
        $collection = new \DCarbone\CollectionPlus();
        $collection->append('value1');
        $this->assertArrayHasKey(0, $collection);
        $this->assertEquals('value1', $collection[0]);
    }
    //</editor-fold>

    //<editor-fold desc="containsMethodImplementation">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::contains
     * @depends testObjectImplementContainsMethod
     * @depends testCanConstructObjectWithArrayParameter
     */
    public function testContainsWithScalarType()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            0,
            1,
            '1',
            null,
            true,
            false,
        ));

        $this->assertTrue($collection->contains(1));
        $this->assertTrue($collection->contains('1'));
        $this->assertTrue($collection->contains(0));
        $this->assertTrue($collection->contains(null));
        $this->assertTrue($collection->contains(false));
        $this->assertTrue($collection->contains(true));
        $this->assertFalse($collection->contains('sandwiches'));
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::contains
     * @depends testObjectImplementContainsMethod
     * @depends testCanConstructObjectWithArrayParameter
     */
    public function testContainsWithObjects()
    {
        $obj1 = new \stdClass();
        $collection = new \DCarbone\CollectionPlus(array($obj1));
        $this->assertTrue($collection->contains($obj1));
    }
    //</editor-fold>

    //<editor-fold desc="removeMethodTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::remove
     * @depends testObjectImplementsRemoveMethod
     * @depends testCanConstructObjectWithArrayParameter
     * @depends testBasicArrayAccessImplementation
     * @depends testCountableImplementation
     */
    public function testCanRemoveElementFromCollectionByIndex()
    {
        $collection = new \DCarbone\CollectionPlus(
            array('key1' => 'value1')
        );

        $removed = $collection->remove('key1');
        $this->assertEquals('value1', $removed);

        $this->assertEquals(0, count($collection));
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::remove
     * @depends testObjectImplementsRemoveMethod
     * @depends testCanConstructObjectWithArrayParameter
     * @depends testBasicArrayAccessImplementation
     * @depends testCountableImplementation
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
     * @depends testObjectImplementsRemoveMethod
     * @depends testCanConstructObjectWithArrayParameter
     * @depends testBasicArrayAccessImplementation
     * @depends testCountableImplementation
     */
    public function testNullReturnedWhenRemovingInvalidIndex()
    {
        $collection = new \DCarbone\CollectionPlus(array('value'));
        $this->assertCount(1, $collection);
        $value = $collection->remove(1);
        $this->assertNull($value);
    }
    //</editor-fold>

    //<editor-fold desc="removeElementTestMethods">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::removeElement
     * @depends testObjectImplementsRemoveElementMethod
     * @depends testCanConstructObjectWithArrayParameter
     * @depends testBasicArrayAccessImplementation
     * @depends testCountableImplementation
     */
    public function testCanRemoveScalarElementFromCollection()
    {
        $element = array('value1');
        $collection = new \DCarbone\CollectionPlus(array('key1' => $element));
        $this->assertCount(1, $collection);

        $removed = $collection->removeElement($element);
        $this->assertTrue($removed);
        $this->assertCount(0, $collection);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::removeElement
     * @depends testObjectImplementsRemoveElementMethod
     * @depends testCanConstructObjectWithArrayParameter
     * @depends testBasicArrayAccessImplementation
     * @depends testCountableImplementation
     */
    public function testCanRemoveObjectElementFromCollection()
    {
        $element = new \stdClass();
        $element->key = 'value';
        $collection = new \DCarbone\CollectionPlus(array($element));
        $this->assertCount(1, $collection);

        $removed = $collection->removeElement($element);
        $this->assertTrue($removed);
        $this->assertCount(0, $collection);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::removeElement
     * @depends testObjectImplementsRemoveElementMethod
     * @depends testCanConstructObjectWithArrayParameter
     */
    public function testGetFalseWhenRemoveElementCalledWithValueNotInCollection()
    {
        $collection = new \DCarbone\CollectionPlus(array('element1'));
        $this->assertFalse($collection->removeElement('element2'));
    }
    //</editor-fold>

    //<editor-fold desc="existsMethodTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::exists
     * @depends testCanConstructObjectWithArrayParameter
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testExistsWithStringGlobalFunctionName(\DCarbone\AbstractCollectionPlus $collection)
    {
        $shouldExist = $collection->exists('_collection_exists_success_test');
        $shouldNotExist = $collection->exists('_collection_exists_failure_test');

        $this->assertTrue($shouldExist);
        $this->assertNotTrue($shouldNotExist);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::exists
     * @uses \CollectionPlusTests
     * @depends testCanConstructObjectWithArrayParameter
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testExistsWithStringObjectStaticMethodName(\DCarbone\AbstractCollectionPlus $collection)
    {
        $shouldExist = $collection->exists(array('\\CollectionPlusTests', '_collection_exists_success_test'));
        $shouldNotExist = $collection->exists(array('\\CollectionPlusTests', '_collection_exists_failure_test'));

        $this->assertTrue($shouldExist);
        $this->assertNotTrue($shouldNotExist);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::exists
     * @depends testCanConstructObjectWithArrayParameter
     * @param \DCarbone\AbstractCollectionPlus $collection
     */
    public function testExistsWithAnonymousFunction(\DCarbone\AbstractCollectionPlus $collection)
    {
        $shouldExist = $collection->exists(function($key, $value) {
            return ($key === 3 && $value === 4);
        });

        $shouldNotExist = $collection->exists(function($key, $value) {
            return ($key === 'tasty' && $value === 'sandwich');
        });

        $this->assertTrue($shouldExist);
        $this->assertNotTrue($shouldNotExist);
    }
    //</editor-fold>

    //<editor-fold desc="SetGetIteratorMethodsTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::setIteratorClass
     * @covers \DCarbone\AbstractCollectionPlus::getIteratorClass
     * @depends testCanSetAndGetCustomIteratorClass
     */
    public function testCanSetValidIteratorClassWithLeadingSlashes()
    {
        $collection = new \DCarbone\CollectionPlus();
        $collection->setIteratorClass('\\ArrayIterator');
        $this->assertEquals('\\ArrayIterator', $collection->getIteratorClass());
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::setIteratorClass
     * @covers \DCarbone\AbstractCollectionPlus::getIteratorClass
     * @depends testCanSetAndGetCustomIteratorClass
     */
    public function testCanSetValidIteratorClassWithoutLeadingSlashes()
    {
        $collection = new \DCarbone\CollectionPlus();
        $collection->setIteratorClass('ArrayIterator');
        $this->assertEquals('\\ArrayIterator', $collection->getIteratorClass());
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::setIteratorClass
     * @depends testCanSetAndGetCustomIteratorClass
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionThrownWhenUndefinedIteratorClassSet()
    {
        $collection = new \DCarbone\CollectionPlus();
        $collection->setIteratorClass('\\MyAwesomeIterator');
    }
    //</editor-fold>

    //<editor-fold desc="getIteratorMethodTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::getIterator
     * @depends testObjectImplementsGetIteratorMethod
     * @depends testCanConstructObjectWithArrayParameter
     * @uses \ArrayIterator
     */
    public function testCanGetDefaultIteratorClass()
    {
        $collection = new \DCarbone\CollectionPlus(
            array('key1' => 'value1', 'key2' => 'value2')
        );

        $arrayIterator = $collection->getIterator();
        $this->assertInstanceOf('\\ArrayIterator', $arrayIterator);
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::getIterator
     * @depends testObjectImplementsGetIteratorMethod
     * @depends testCanConstructObjectWithArrayParameter
     * @depends testCanSetValidIteratorClassWithLeadingSlashes
     * @uses \MySuperAwesomeIteratorClass
     */
    public function testCanGetCustomIteratorClass()
    {
        $collection = new \DCarbone\CollectionPlus(
            array('key1' => 'value1', 'key2' => 'value2')
        );

        $collection->setIteratorClass('\\MySuperAwesomeIteratorClass');
        $arrayIterator = $collection->getIterator();
        $this->assertInstanceOf('\\MySuperAwesomeIteratorClass', $arrayIterator);
    }
    //</editor-fold>

    //<editor-fold desc="mapMethodTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::map
     * @depends testObjectImplementsMapMethod
     * @expectedException \InvalidArgumentException
     */
    public function testMapThrowsExceptionWhenUncallableFuncPassed()
    {
        $collection = new \DCarbone\CollectionPlus();
        $collection->map('this_function_doesnt_exist');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::map
     * @depends testObjectImplementsMapMethod
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
     * @covers \DCarbone\AbstractCollectionPlus::map
     * @depends testObjectImplementsMapMethod
     * @uses \CollectionPlusTests
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
     * @covers \DCarbone\AbstractCollectionPlus::map
     * @depends testObjectImplementsMapMethod
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
     * @covers \DCarbone\AbstractCollectionPlus::map
     * @depends testObjectImplementsMapMethod
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
    //</editor-fold>

    //<editor-fold desc="filterMethodTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::filter
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
     * @covers \DCarbone\AbstractCollectionPlus::filter
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
     * @covers \DCarbone\AbstractCollectionPlus::filter
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
     * @covers \DCarbone\AbstractCollectionPlus::filter
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
     * @covers \DCarbone\AbstractCollectionPlus::filter
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
    //</editor-fold>

    //<editor-fold desc="sortMethodsTests">
    /**
     * @covers \DCarbone\AbstractCollectionPlus::sort
     */
    public function testSort()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'z', 'q', 'a', 'b',
        ));

        $collection->sort();
        $this->assertEquals(
            'a',
            $collection->firstValue(),
            'First value expected to be "a", saw "'.$collection->firstValue().'"');

        $this->assertEquals(
            'z',
            $collection->lastValue(),
            'Last value expected to be "z", saw "'.$collection->lastValue().'"');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::rsort
     */
    public function testRSort()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'z', 'q', 'a', 'b',
        ));

        $collection->rsort();
        $this->assertEquals(
            'z',
            $collection->firstValue(),
            'First value expected to be "z", saw "'.$collection->firstValue().'"');

        $this->assertEquals(
            'a',
            $collection->lastValue(),
            'Last value expected to be "a", saw "'.$collection->lastValue().'"');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::usort
     */
    public function testUSortWithAnonymousFunction()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'z', 'q', 'a', 'b',
        ));

        $collection->usort(function($a, $b) {
            return ($a > $b ? 1 : -1);
        });

        $this->assertEquals(
            'a',
            $collection->firstValue(),
            'First value expected to be "a", saw "'.$collection->firstValue().'"');
        $this->assertEquals(
            'z',
            $collection->lastValue(),
            'Last value expected to be "a", saw "'.$collection->lastValue().'"');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::ksort
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
        $this->assertEquals(
            'a',
            $collection->firstKey(),
            'First key expected to be "a", saw "'.$collection->firstKey().'"');

        $this->assertEquals(
            'z',
            $collection->lastKey(),
            'Last key expected to be "z", saw "'.$collection->lastKey().'"');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::krsort
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
        $this->assertEquals(
            'z',
            $collection->firstKey(),
            'First key expected to be "z", saw "'.$collection->firstKey().'"');

        $this->assertEquals(
            'a',
            $collection->lastKey(),
            'Last key expected to be "a", saw "'.$collection->lastKey().'"');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::uksort
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
        $this->assertEquals(
            'a',
            $collection->firstKey(),
            'First key expected to be "a", saw "'.$collection->firstKey().'"');

        $this->assertEquals(
            'z',
            $collection->lastKey(),
            'Last key expected to be "z", saw "'.$collection->lastKey().'"');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::asort
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

        $this->assertEquals(
            'a',
            $collection->firstValue(),
            'First value expected to be "a", saw "'.$collection->firstValue().'"');
        $this->assertEquals(
            'a',
            $collection->firstKey(),
            'First key expected to be "a", saw "'.$collection->firstKey().'"');

        $this->assertEquals(
            'z',
            $collection->lastValue(),
            'Last value expected to be "z", saw "'.$collection->lastValue().'"');
        $this->assertEquals(
            'z',
            $collection->lastKey(),
            'Last key expected to be "z", saw "'.$collection->lastKey().'"');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::arsort
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

        $this->assertEquals(
            'z',
            $collection->firstValue(),
            'First value expected to be "z", saw "'.$collection->firstValue().'"');
        $this->assertEquals(
            'z',
            $collection->firstKey(),
            'First key expected to be "z", saw "'.$collection->firstKey().'"');

        $this->assertEquals(
            'a',
            $collection->lastValue(),
            'Last value expected to be "a", saw "'.$collection->lastValue().'"');
        $this->assertEquals(
            'a',
            $collection->lastKey(),
            'Last key expected to be "a", saw "'.$collection->lastKey().'"');
    }

    /**
     * @covers \DCarbone\AbstractCollectionPlus::uasort
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

        $this->assertEquals(
            'a',
            $collection->firstValue(),
            'First value expected to be "a", saw "'.$collection->firstValue().'"');
        $this->assertEquals(
            'a',
            $collection->firstKey(),
            'First key expected to be "a", saw "'.$collection->firstKey().'"');

        $this->assertEquals(
            'z',
            $collection->lastValue(),
            'Last value expected to be "z", saw "'.$collection->lastValue().'"');
        $this->assertEquals(
            'z',
            $collection->lastKey(),
            'Last key expected to be "z", saw "'.$collection->lastKey().'"');
    }
    //</editor-fold>

    /**
     * @covers \DCarbone\AbstractCollectionPlus::hasChildren
     * @covers \DCarbone\AbstractCollectionPlus::getChildren
     * @depends testObjectImplementsRecursiveIterator
     * @depends testCanConstructObjectWithArrayParameter
     */
    public function testRecursiveIteratorImplementation()
    {
        $collection = new \DCarbone\CollectionPlus(array(
            'key1' => array('value1'),
            'key2' => 'value2',
            'key3' => array('value3'),
        ));

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
}