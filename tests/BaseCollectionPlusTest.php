<?php

class BaseCollectionPlusTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::__construct
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @return BaseCollectionPlusTest
     */
    public function testCollectionCanBeConstructedFroValidConstructorArguments()
    {
        $collection = new \DCarbone\CollectionPlus\BaseCollectionPlus(array('test' => 'value'));
        $this->assertInstanceOf('DCarbone\\CollectionPlus\\AbstractCollectionPlus', $collection);
        return $collection;
    }

    /**
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
     * @depends testCollectionCanBeConstructedFroValidConstructorArguments
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
     * @depends testCollectionCanBeConstructedFroValidConstructorArguments
     * @param \DCarbone\CollectionPlus\AbstractCollectionPlus $collection
     */
    public function testCanGetArrayKeysOfCollection(\DCarbone\CollectionPlus\AbstractCollectionPlus $collection)
    {
        $keys = $collection->array_keys();
        $this->assertTrue(is_array($keys), '"$collection->array_keys()" did not return an array!');
        $this->assertEquals(1, count($keys));
        $this->assertContains('test', $keys, 'Did not see key "test" in "$collection->array_keys()" result');
    }


}
