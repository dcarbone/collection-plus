<?php

/**
 * @param mixed $key
 * @param mixed $value
 * @return bool
 */
function _collection_exists_success_test($key, $value)
{
    return ($key === 3 && $value === 4);
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
