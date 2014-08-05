<?php

/**
 * Class ExistsTests
 */
class ExistsTests
{
    /**
     * @param mixed $key
     * @param mixed $value
     * @return bool
     */
    public static function _exists_function_success_test($key, $value)
    {
        return ($key === 'test' && $value === 'value');
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return bool
     */
    public static function _exists_function_failure_test($key, $value)
    {
        return ($key === 'tasty' && $value === 'sandwich');
    }
}

/**
 * Class MapTests
 */
class MapTests
{
    /**
     * @param $value
     * @return null
     */
    public static function _map_function_change_odd_values_to_null($value)
    {
        if ($value % 2 === 0)
            return $value;

        return null;
    }
}

/**
 * Class FilterTests
 */
class FilterTests
{
    /**
     * @param bool $value
     * @return bool
     */
    public static function _filter_function_remove_true_values($value)
    {
        return ($value === false);
    }
}

/**
 * Class MySuperAwesomeIteratorClass
 */
class MySuperAwesomeIteratorClass extends \ArrayIterator { }

/**
 * Class MySuperAwesomeCollectionClass
 */
class MySuperAwesomeCollectionClass extends \DCarbone\CollectionPlus\BaseCollectionPlus { }