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