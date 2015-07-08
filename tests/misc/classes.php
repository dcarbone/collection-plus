<?php

/**
 * Class CollectionPlusTests
 */
class CollectionPlusTests
{
    /**
     * @param mixed $key
     * @param mixed $value
     * @return bool
     */
    public static function _collection_exists_success_test($key, $value)
    {
        return ($key === 'test' && $value === 'value');
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return bool
     */
    public static function _collection_exists_failure_test($key, $value)
    {
        return ($key === 'tasty' && $value === 'sandwich');
    }

    /**
     * @param $value
     * @return null
     */
    public static function _collection_map_change_odd_values_to_null($value)
    {
        if ($value % 2 === 0)
            return $value;

        return null;
    }

    /**
     * @param bool $value
     * @return bool
     */
    public static function _collection_filter_remove_true_values($value)
    {
        return ($value === false);
    }
}

class MySuperAwesomeIteratorClass extends \ArrayIterator { }
class MySuperAwesomeCollectionClass extends \DCarbone\CollectionPlus { }
class im_just_a_class {}
