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

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::offsetExists
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::offsetGet
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @depends testCollectionCanBeConstructedFroValidConstructorArguments
     * @param \DCarbone\CollectionPlus\AbstractCollectionPlus $collection
     */
    public function testCanAccessCollectionPropertyAsArray(\DCarbone\CollectionPlus\AbstractCollectionPlus $collection)
    {
        $this->assertArrayHasKey('test', $collection, 'Passed "$collection" object did not contain key "test"');
        $value = $collection['test'];
        $this->assertEquals('value', $value);
    }

    /**
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @depends testCollectionCanBeConstructedFroValidConstructorArguments
     * @param \DCarbone\CollectionPlus\AbstractCollectionPlus $collection
     */
    public function testCanAccessCollectionPropertyAsObject(\DCarbone\CollectionPlus\AbstractCollectionPlus $collection)
    {
        $this->assertArrayHasKey('test', $collection, 'Passed "$collection" object did not contain key "test"');
        $value = $collection->test;
        $this->assertEquals('value', $value);
    }
}
