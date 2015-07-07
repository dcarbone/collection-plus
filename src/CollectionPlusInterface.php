<?php namespace DCarbone;

/**
 * Interface CollectionPlusInterface
 * @package DCarbone
 */
interface CollectionPlusInterface extends \Countable, \RecursiveIterator, \SeekableIterator, \ArrayAccess, \Serializable, \DCarbone\JsonSerializable
{
    /**
     * @return string
     */
    public function __toString();

    /**
     * @return array
     */
    public function getArrayCopy();

    /**
     * @param mixed $param
     * @return mixed
     */
    public function &__get($param);

    /**
     * @param mixed $name
     * @param mixed $value
     * @return void
     */
    public function __set($name, $value);

    /**
     * @return array
     */
    public function keys();

    /**
     * @return array
     */
    public function values();

    /**
     * Get an Iterator instance for this data set
     *
     * @return \ArrayIterator
     */
    public function getIterator();

    /**
     * This method was inspired by Zend Framework 2.2.x PhpReferenceCompatibility class
     *
     * @link https://github.com/zendframework/zf2/blob/release-2.2.6/library/Zend/Stdlib/ArrayObject/PhpReferenceCompatibility.php#L179
     *
     * @param $dataSet
     * @return array
     * @throws \InvalidArgumentException
     */
    public function exchangeArray($dataSet);

    /**
     * Set a value on this collection
     *
     * @param mixed $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value);

    /**
     * Append a value
     *
     * @param mixed $value
     * @return void
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
    public function exists($func);

    /**
     * Return index of desired key
     *
     * @param mixed $value
     * @return mixed
     */
    public function indexOf($value);

    /**
     * Remove and return an element
     *
     * @param $index
     * @return mixed|null
     */
    public function remove($index);

    /**
     * @param $element
     * @return bool
     */
    public function removeElement($element);

    /**
     * @return string
     */
    public function getIteratorClass();

    /**
     * @param string $class
     * @return void
     */
    public function setIteratorClass($class);

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
    public function map($func);

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
    public function filter($func = null);

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

    /**
     * @return mixed|null
     */
    public function getFirstKey();

    /**
     * @return mixed|null
     */
    public function getLastKey();

    /**
     * Sort values by standard PHP sort method
     *
     * @link http://www.php.net/manual/en/function.sort.php
     *
     * @param int $flags
     * @return bool
     */
    public function sort($flags = SORT_REGULAR);

    /**
     * Reverse sort values
     *
     * @link http://www.php.net/manual/en/function.rsort.php
     *
     * @param int $flags
     * @return bool
     */
    public function rsort($flags = SORT_REGULAR);

    /**
     * Sort values by custom function
     *
     * @link http://www.php.net/manual/en/function.usort.php
     *
     * @param string|array $func
     * @return bool
     */
    public function usort($func);

    /**
     * Sort by keys
     *
     * @link http://www.php.net/manual/en/function.ksort.php
     *
     * @param int $flags
     * @return bool
     */
    public function ksort($flags = SORT_REGULAR);

    /**
     * Reverse sort by keys
     *
     * @link http://www.php.net/manual/en/function.krsort.php
     *
     * @param int $flags
     * @return bool
     */
    public function krsort($flags = SORT_REGULAR);

    /**
     * Sort by keys with custom function
     *
     * http://www.php.net/manual/en/function.uksort.php
     *
     * @param string|array $func
     * @return bool
     */
    public function uksort($func);

    /**
     * Sort values while retaining indices.
     *
     * @link http://www.php.net/manual/en/function.asort.php
     *
     * @param int $flags
     * @return bool
     */
    public function asort($flags = SORT_REGULAR);

    /**
     * Reverse sort values while retaining indices
     *
     * @link http://www.php.net/manual/en/function.arsort.php
     *
     * @param int $flags
     * @return bool
     */
    public function arsort($flags = SORT_REGULAR);

    /**
     * Sort values while preserving indices with custom function
     *
     * @link http://www.php.net/manual/en/function.uasort.php
     *
     * @param $func
     * @return bool
     */
    public function uasort($func);
}