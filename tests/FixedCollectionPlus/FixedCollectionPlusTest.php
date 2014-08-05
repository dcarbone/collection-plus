<?php

date_default_timezone_set('UTC');

require_once realpath(dirname(__DIR__).'/misc/functions.php');
require_once realpath(dirname(__DIR__).'/misc/classes.php');

/**
 * Class FixedCollectionPlusTest
 */
class FixedCollectionPlusTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::getSize
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testCanConstructNewFixedCollectionWithNoParameter()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus();

        $this->assertInstanceOf(
            '\\DCarbone\\CollectionPlus\\BaseFixedCollectionPlus',
            $fixedCollection);

        $this->assertEquals(0, $fixedCollection->getSize());
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::getSize
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testCanConstructNewFixedCollectionWithValidParameter()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus(5);

        $this->assertInstanceOf(
            '\\DCarbone\\CollectionPlus\\BaseFixedCollectionPlus',
            $fixedCollection);

        $this->assertEquals(5, $fixedCollection->getSize());
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
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
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus(5);
        $this->assertTrue(
            method_exists($fixedCollection, '__toArray'),
            '::__toArray not defined');

        $array = $fixedCollection->__toArray();
        $this->assertTrue(
            is_array($array),
            '::__toArray returned non-array value');
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::getSize
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::append
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testAppendMethod()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus(0);
        $this->assertEquals(0, $fixedCollection->getSize());

        $fixedCollection->append('test');
        $this->assertEquals(1, $fixedCollection->getSize());

        $this->assertContains('test', $fixedCollection);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::contains
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::fromArray
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::offsetGet
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testContainsReturnTrueWithValidSearch()
    {
        $fixedCollection = \DCarbone\CollectionPlus\BaseFixedCollectionPlus::fromArray(
            array(1, 2, 3, 'test', 5));

        $contains = $fixedCollection->contains('test');
        $this->assertTrue($contains, '::contains returned false when expected to return true');
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::contains
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::fromArray
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::offsetGet
     */
    public function testContainsReturnsFalseWithInvalidSearch()
    {
        $fixedCollection = \DCarbone\CollectionPlus\BaseFixedCollectionPlus::fromArray(
            array(1, 2, 3, 'test', 5));

        $contains = $fixedCollection->contains('sandwiches');
        $this->assertFalse($contains, '::contains returned true when expected to return false');
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::setSize
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::getSize
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::offsetSet
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testCanIncreaseSizeOfEmptyCollectionWithValidInteger()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus();
        $this->assertEquals(0, $fixedCollection->getSize());
        $fixedCollection->setSize(1);
        $this->assertEquals(1, $fixedCollection->getSize());
        $fixedCollection[0] = 'test';
        $this->assertTrue(($fixedCollection[0] === 'test'));
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::setSize
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testCanReduceSizeOfCollectionWIthValidInteger()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus(50);

        $this->assertEquals(50, $fixedCollection->getSize());
        $fixedCollection->setSize(25);
        $this->assertEquals(25, $fixedCollection->getSize());
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::setSize
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionThrownWhenSettingSizeOfCollectionWithNonIntegerParameter()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus(25);
        $fixedCollection->setSize('sandwich');
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::setSize
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionThrownWhenSettingSizeOfCollectionWithNegativeInteger()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus(25);
        $fixedCollection->setSize(-5);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::setSize
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::isEmpty
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testEmptyMethod()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus();
        $this->assertTrue($fixedCollection->isEmpty(), '::isEmpty() returned false when expected true');
        $fixedCollection->setSize(1);
        $this->assertFalse($fixedCollection->isEmpty(), '::isEmpty() returned true when expected false');
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::fromArray
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::first
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::isEmpty
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testCanGetFirstResultFromPopulatedCollection()
    {
        $fixedCollection = \DCarbone\CollectionPlus\BaseFixedCollectionPlus::fromArray(
            array('value1', 'value2', 'value3'));

        $first = $fixedCollection->first();
        $this->assertTrue(($first === 'value1'));
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::fromArray
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::last
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::isEmpty
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testCanGetLastResultFromPopulatedCollection()
    {
        $fixedCollection = \DCarbone\CollectionPlus\BaseFixedCollectionPlus::fromArray(
            array('value1', 'value2', 'value3'));

        $last = $fixedCollection->last();
        $this->assertTrue(($last === 'value3'));
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::first
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::isEmpty
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testFirstReturnsNullWithEmptyCollection()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus();
        $first = $fixedCollection->first();
        $this->assertNull($first);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::last
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::isEmpty
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testLastReturnsNullWithEmptyCollection()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus();
        $last = $fixedCollection->last();
        $this->assertNull($last);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::exists
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::fromArray
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testExistsWithStringGlobalFunctionName()
    {
        $fixedCollection = \DCarbone\CollectionPlus\BaseFixedCollectionPlus::fromArray(
            array('no', 'yes', 'test', true, false));

        $shouldExist = $fixedCollection->exists('_fixed_collection_exists_success_test');
        $shouldNotExist = $fixedCollection->exists('_fixed_collection_exists_failure_test');

        $this->assertTrue($shouldExist);
        $this->assertFalse($shouldNotExist);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::fromArray
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::exists
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     * @uses \FixedCollectionPlusTests
     */
    public function testExistsWithStringObjectStaticMethodName()
    {
        $fixedCollection = \DCarbone\CollectionPlus\BaseFixedCollectionPlus::fromArray(
            array('no', 'yes', 'test', true, false));

        $shouldExist = $fixedCollection->exists(array('\\FixedCollectionPlusTests', '_fixed_collection_exists_success_test'));
        $shouldNotExist = $fixedCollection->exists(array('\\FixedCollectionPlusTests', '_fixed_collection_exists_failure_test'));

        $this->assertTrue($shouldExist);
        $this->assertNotTrue($shouldNotExist);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::exists
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::fromArray
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testExistsWithAnonymousFunction()
    {
        $fixedCollection = \DCarbone\CollectionPlus\BaseFixedCollectionPlus::fromArray(
            array('no', 'yes', 'test', true, false));

        $shouldExist = $fixedCollection->exists(function($value) {
            return ($value === 'test');
        });

        $shouldNotExist = $fixedCollection->exists(function($value) {
            return ($value === 'sandwich');
        });

        $this->assertTrue($shouldExist);
        $this->assertNotTrue($shouldNotExist);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::map
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     * @expectedException \InvalidArgumentException
     */
    public function testMapThrowsExceptionWhenUncallableFuncPassed()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus();
        $fixedCollection->map('this_function_doesnt_exist');
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::map
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::offsetSet
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testMapWithGlobalFunction()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus(10);
        for($i = 0; $i < 10; $i++)
            $fixedCollection[$i] = $i;

        $this->assertEquals(10, count($fixedCollection));

        $mapped = $fixedCollection->map('_fixed_collection_map_change_odd_values_to_null');
        $this->assertEquals(10, count($mapped));

        $this->assertNull($mapped[1]);
        $this->assertNotNull($mapped[0]);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::map
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::offsetSet
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     * @uses FixedCollectionPlusTests
     */
    public function testMapWithObjectStaticMethod()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus(10);
        for($i = 0; $i < 10; $i++)
            $fixedCollection[$i] = $i;

        $this->assertEquals(10, count($fixedCollection));

        $mapped = $fixedCollection->map(array('FixedCollectionPlusTests', '_fixed_collection_map_change_odd_values_to_null'));
        $this->assertEquals(10, count($mapped));

        $this->assertNull($mapped[1]);
        $this->assertNotNull($mapped[0]);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::map
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::offsetSet
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testMapWithAnonymousFunction()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus(10);
        for($i = 0; $i < 10; $i++)
            $fixedCollection[$i] = $i;

        $mapped = $fixedCollection->map(function ($value) {
            if ($value % 2 === 0)
                return $value;

            return null;
        });
        $this->assertEquals(10, count($mapped));

        $this->assertNull($mapped[1]);
        $this->assertNotNull($mapped[0]);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::map
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::offsetSet
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     * @uses \MySuperAwesomeCollectionClass
     */
    public function testMapWithAnonymousFunctionReturnsInstanceOfExtendedClass()
    {
        $fixedCollection = new MySuperAwesomeFixedCollectionClass(10);

        for($i = 0; $i < 10; $i++)
            $fixedCollection[$i] = $i;

        $mapped = $fixedCollection->map(function ($value) {
            if ($value % 2 === 0)
                return $value;

            return null;
        });
        
        $this->assertEquals(10, count($mapped));

        $this->assertNull($mapped[1]);
        $this->assertNotNull($mapped[0]);

        $this->assertInstanceOf('\\MySuperAwesomeFixedCollectionClass', $mapped);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::filter
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::offsetSet
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::count
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testFilterWithNoCallableParameter()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus(10);
        for($i = 0; $i < 10; $i++)
        {
            if ($i % 2 === 0)
                $fixedCollection[$i] = true;
            else
                $fixedCollection[$i] = false;
        }

        $this->assertEquals(10, count($fixedCollection));

        $filtered = $fixedCollection->filter();
        $this->assertEquals(5, count($filtered));
        $this->assertNotContains(false, $filtered);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::filter
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::offsetSet
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::count
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testFilterWithGlobalFunction()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus(10);
        for($i = 0; $i < 10; $i++)
        {
            if ($i % 2 === 0)
                $fixedCollection[$i] = true;
            else
                $fixedCollection[$i] = false;
        }

        $this->assertEquals(10, count($fixedCollection));

        $filtered = $fixedCollection->filter('_collection_filter_remove_true_values');
        $this->assertEquals(5, count($filtered));
        $this->assertNotContains(true, $filtered);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::filter
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::offsetSet
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::count
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     * @uses \CollectionPlusTests
     */
    public function testFilterWithObjectStaticFunction()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus(10);
        for($i = 0; $i < 10; $i++)
        {
            if ($i % 2 === 0)
                $fixedCollection[$i] = true;
            else
                $fixedCollection[$i] = false;
        }

        $this->assertEquals(10, count($fixedCollection));

        $filtered = $fixedCollection->filter(array('CollectionPlusTests', '_collection_filter_remove_true_values'));
        $this->assertEquals(5, count($filtered));
        $this->assertNotContains(true, $filtered);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::filter
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::offsetSet
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::count
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testFilterWithAnonymousFunction()
    {
        $fixedCollection = new \DCarbone\CollectionPlus\BaseFixedCollectionPlus(10);
        for($i = 0; $i < 10; $i++)
        {
            if ($i % 2 === 0)
                $fixedCollection[$i] = true;
            else
                $fixedCollection[$i] = false;
        }

        $this->assertEquals(10, count($fixedCollection));

        $filtered = $fixedCollection->filter(function ($value) {
            return ($value === false);
        });

        $this->assertEquals(5, count($filtered));
        $this->assertNotContains(true, $filtered);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::filter
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::offsetSet
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testFilterWithAnonymousFunctionReturnsInstanceOfExtendedClass()
    {
        $fixedCollection = new MySuperAwesomeFixedCollectionClass(10);
        for($i = 0; $i < 10; $i++)
        {
            if ($i % 2 === 0)
                $fixedCollection[$i] = true;
            else
                $fixedCollection[$i] = false;
        }

        $this->assertEquals(10, count($fixedCollection));

        $filtered = $fixedCollection->filter(function ($value) {
            return ($value === false);
        });

        $this->assertInstanceOf('\\MySuperAwesomeFixedCollectionClass', $filtered);
        $this->assertEquals(5, count($filtered));
        $this->assertNotContains(true, $filtered);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::fromArray
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::indexOf
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::offsetGet
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testIndexOfReturnsValidIndexWithValidParameter()
    {
        $fixedCollection = \DCarbone\CollectionPlus\BaseFixedCollectionPlus::fromArray(
            array('value1', 'value2', 'value3'));

        $idx = $fixedCollection->indexOf('value2');
        $this->assertEquals(1, $idx);
    }

    /**
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::__construct
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::fromArray
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::indexOf
     * @covers \DCarbone\CollectionPlus\AbstractFixedCollectionPlus::offsetGet
     * @uses \DCarbone\CollectionPlus\AbstractFixedCollectionPlus
     */
    public function testIndexOfReturnsNegativeOneWithNonExistentParameter()
    {
        $fixedCollection = \DCarbone\CollectionPlus\BaseFixedCollectionPlus::fromArray(
            array('value1', 'value2', 'value3'));

        $idx = $fixedCollection->indexOf('sandwiches');
        $this->assertEquals(-1, $idx);
    }
}