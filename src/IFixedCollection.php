<?php namespace DCarbone\CollectionPlus;

/**
 * Interface IFixedCollection
 * @package DCarbone\CollectionPlus
 */
interface IFixedCollection
{
    /**
     * @return array
     */
    public function __toArray();

    /**
     * Append a value
     *
     * @param mixed $value
     * @return bool
     */
    public function append($value);

    /**
     * Try to determine if an identical element is already in this collection
     *
     * @param mixed $element
     * @return bool
     */
    public function contains($element);

    /**
     * Custom "contains" method
     *
     * @param callable $func
     * @return bool
     */
    public function exists(\Closure $func);

    /**
     * Applies array_map to this dataset, and returns a new object.
     *
     * @link http://us1.php.net/array_map
     *
     * They scope "static" is used so that an instance of the extended class is returned.
     *
     * @param callable $func
     * @return static
     */
    public function map(\Closure $func);

    /**
     * Applies array_filter to internal dataset, returns new instance with resulting values.
     *
     * @link http://www.php.net/manual/en/function.array-filter.php
     *
     * Inspired by:
     *
     * @link http://www.doctrine-project.org/api/common/2.3/source-class-Doctrine.Common.Collections.ArrayCollection.html#377-387
     *
     * @param callable $func
     * @return static
     */
    public function filter(\Closure $func = null);

    /**
     * Return index of desired key
     *
     * @param mixed $value
     * @return mixed
     */
    public function indexOf($value);

    /**
     * Is this collection empty?
     *
     * @return bool
     */
    public function isEmpty();

    /**
     * Return the first item in the dataset
     *
     * @return mixed
     */
    public function first();

    /**
     * Return the last element in the dataset
     *
     * @return mixed
     */
    public function last();
}