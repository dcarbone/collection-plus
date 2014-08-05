<?php

/**
 * @param mixed $key
 * @param mixed $value
 * @return bool
 */
function _collection_exists_success_test($key, $value)
{
    return ($key === 'test' && $value === 'value');
}

/**
 * @param mixed $key
 * @param mixed $value
 * @return bool
 */
function _collection_exists_failure_test($key, $value)
{
    return ($key === 'tasty' && $value === 'sandwich');
}

/**
 * @param mixed $value
 * @return mixed
 */
function _collection_map_change_odd_values_to_null($value)
{
    if ($value % 2 === 0)
        return $value;

    return null;
}

/**
 * @param bool $value
 * @return bool
 */
function _collection_filter_remove_true_values($value)
{
    return ($value === false);
}

/**
 * @param $value
 * @return bool
 */
function _fixed_collection_exists_success_test($value)
{
    return ($value === 'test');
}

/**
 * @param $value
 * @return bool
 */
function _fixed_collection_exists_failure_test($value)
{
    return ($value === 'sandwich');
}

/**
 * @param $value
 * @return null
 */
function _fixed_collection_map_change_odd_values_to_null($value)
{
    if ($value % 2 === 0)
        return $value;

    return null;
}

/**
 * @param $value
 * @return bool
 */
function _fixed_collection_filter_remove_true_values($value)
{
    return ($value === false);
}