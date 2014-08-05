<?php

date_default_timezone_set('UTC');

require_once realpath(__DIR__.'/test-scripts/functions.php');
require_once realpath(__DIR__.'/test-scripts/classes.php');

/**
 * Class FixedCollectionPlusTest
 */
class FixedCollectionPlusTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::getSize
     * @return \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testCanConstructNewFixedCollectionWithNoParameter()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus();

        $this->assertInstanceOf(
            '\\DCarbone\\CollectionPlus\\BaseFixedCollectionPlus',
            $fixedCollection);

        $this->assertEquals(0, $fixedCollection->getSize());

        return $fixedCollection;
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::getSize
     * @return \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testCanConstructNewFixedCollectionWithValidParameter()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus(5);

        $this->assertInstanceOf(
            '\\DCarbone\\CollectionPlus\\BaseFixedCollectionPlus',
            $fixedCollection);

        $this->assertEquals(5, $fixedCollection->getSize());

        return $fixedCollection;
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @uses \DCarbone\CollectionPlus\AbstractCollectionPlus
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionThrownWhenTryingToConstructCollectionWithInvalidParameter()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus('sandwiches');
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::fromArray
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::getSize
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testCanCreateCollectionFromArrayWithEmptyArray()
    {
        $fixedCollection = \DCarbone\CollectionPlus\BaseFixedCollectionPlus::fromArray(array());

        $this->assertInstanceOf('\\DCarbone\\CollectionPlus\\BaseFixedCollectionPlus', $fixedCollection);
        $this->assertEquals(0, $fixedCollection->getSize());
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::fromArray
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::getSize
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testCanCreateCollectionFromArrayWithAutoIndexedArray()
    {
        $fixedCollection = \DCarbone\CollectionPlus\BaseFixedCollectionPlus::fromArray(
            array('value1', 'value2', 'value3', 5));

        $this->assertInstanceOf(
            '\\DCarbone\\CollectionPlus\\AbstractFixedCollectionPlus',
            $fixedCollection);

        $this->assertEquals(4, $fixedCollection->getSize());
        $this->assertEquals(5, $fixedCollection[3]);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::fromArray
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::getSize
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testCanCreateCollectionFromArrayWithIntKeyArraySavingIndexes()
    {
        $fixedCollection = \DCarbone\CollectionPlus\BaseFixedCollectionPlus::fromArray(
            array(10 => '10', 11 => '11', 12, 'thirteen'));

        $this->assertInstanceOf(
            '\\DCarbone\\CollectionPlus\\AbstractFixedCollectionPlus',
            $fixedCollection);

        $this->assertEquals(14, $fixedCollection->getSize());
        $this->assertEquals('10', $fixedCollection[10]);
        $this->assertEquals(12, $fixedCollection[12]);
        $this->assertNull($fixedCollection[0]);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::fromArray
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionThrownWhenUsingFromArrayWithStringIndexedArraySavingIndexes()
    {
        $fixedCollection = \DCarbone\CollectionPlus\BaseFixedCollectionPlus::fromArray(
            array(1, 2, 3, 'test' => 'value', 7, 8, 9));
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::fromArray
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::offsetGet
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testCanCreateCollectionFromArrayWithIntAndFloatKeyArrayIgnoringIndexes()
    {
        $fixedCollection = \DCarbone\CollectionPlus\BaseFixedCollectionPlus::fromArray(
            array(500 => 500, 1 => 1, 43 => 43), false);

        $this->assertInstanceOf(
            '\\DCarbone\\CollectionPlus\\AbstractFixedCollectionPlus',
            $fixedCollection);

        $this->assertEquals(3, $fixedCollection->getSize());
        $this->assertEquals(500, $fixedCollection[0]);
        $this->assertEquals(1, $fixedCollection[1]);
        $this->assertEquals(43, $fixedCollection[2]);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::fromArray
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::offsetGet
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testCanCreateCollectionFromArrayWithStringKeyArrayIgnoringIndexes()
    {
        $fixedCollection = \DCarbone\CollectionPlus\BaseFixedCollectionPlus::fromArray(
            array('500' => 500, '1' => 1, '43' => 43), false);

        $this->assertInstanceOf(
            '\\DCarbone\\CollectionPlus\\AbstractFixedCollectionPlus',
            $fixedCollection);

        $this->assertEquals(3, $fixedCollection->getSize());
        $this->assertEquals(500, $fixedCollection[0]);
        $this->assertEquals(1, $fixedCollection[1]);
        $this->assertEquals(43, $fixedCollection[2]);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__toArray
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testToArrayMethod()
    {
        $collection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus(5);
        $this->assertTrue(
            method_exists($collection, '__toArray'),
            '::__toArray not defined');

        $array = $collection->__toArray();
        $this->assertTrue(
            is_array($array),
            '::__toArray returned non-array value');
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractCollectionPlus::append
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testAppendMethod()
    {
        $collection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus(0);
        $this->assertEquals(0, $collection->getSize());

        $collection->append('test');
        $this->assertEquals(1, $collection->getSize());

        $this->assertContains('test', $collection);
    }
}
