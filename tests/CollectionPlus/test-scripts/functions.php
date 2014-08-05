<?php

/**
 * @param mixed $key
 * @param mixed $value
 * @return bool
 */
function _exists_function_success_test($key, $value)
{
    return ($key === 'test' && $value === 'value');
}

/**
 * @param mixed $key
 * @param mixed $value
 * @return bool
 */
function _exists_function_failure_test($key, $value)
{
    return ($key === 'tasty' && $value === 'sandwich');
}

/**
 * @param mixed $value
 * @return mixed
 */
function _map_function_change_odd_values_to_null($value)
{
    if ($value % 2 === 0)
        return $value;

    return null;
}

/**
 * @param bool $value
 * @return bool
 */
function _filter_function_remove_true_values($value)
{
    return ($value === false);
}