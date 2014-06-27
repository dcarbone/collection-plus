<?php namespace DCarbone\CollectionPlus;

/**
 * Class AbstractFixedCollectionPlus
 * @package DCarbone\CollectionPlus
 */
class AbstractFixedCollectionPlus extends \SplFixedArray implements IFixedCollection
{
    /**
     * @return array
     */
    public function __toArray()
    {
        return parent::toArray();
    }

    /**
     * Append a value
     *
     * @param mixed $value
     * @return bool
     */
    public function append($value)
    {
        $this->offsetSet(null, $value);
        return true;
    }

    /**
     * Try to determine if an identical element is already in this collection
     *
     * @param mixed $element
     * @return bool
     */
    public function contains($element)
    {
        return in_array($element, $this->toArray(), true);
    }

    /**
     * Custom "contains" method
     *
     * @param callable $func
     * @return bool
     */
    public function exists(\Closure $func)
    {
        foreach($this as $element)
        {
            if ($func($element))
                return true;
        }

        return false;
    }

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
    public function map(\Closure $func)
    {
        return static::fromArray(array_map($func, $this->toArray()));
    }

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
    public function filter(\Closure $func = null)
    {
        if ($func === null)
            return static::fromArray(array_filter($this->toArray()));

        return static::fromArray(array_filter($this->toArray(), $func));
    }

    /**
     * Return index of desired key
     *
     * @param mixed $value
     * @return mixed
     */
    public function indexOf($value)
    {
        return array_search($value, $this->toArray(), true);
    }

    /**
     * Is this collection empty?
     *
     * @return bool
     */
    public function isEmpty()
    {
        return (count($this) === 0);
    }

    /**
     * Return the first item in the dataset
     *
     * @return mixed
     */
    public function first()
    {
        if ($this->isEmpty())
            return null;

        return $this[0];
    }

    /**
     * Return the last element in the dataset
     *
     * @return mixed
     */
    public function last()
    {
        if ($this->isEmpty())
            return null;

        return $this[count($this)-1];
    }

    /**
     * Sort values by standard PHP sort method
     *
     * @link http://www.php.net/manual/en/function.sort.php
     *
     * @param int $flags
     * @return bool
     */
    public function sort($flags = SORT_REGULAR)
    {
        $internalArray = $this->toArray();
        $sort = sort($internalArray, $flags);
        foreach($internalArray as $offset=>$item)
        {
            $this->offsetSet($offset, $item);
        }

        return $sort;
    }

    /**
     * Reverse sort values
     *
     * @link http://www.php.net/manual/en/function.rsort.php
     *
     * @param int $flags
     * @return bool
     */
    public function rsort($flags = SORT_REGULAR)
    {
        $internalArray = $this->toArray();
        $sort = rsort($internalArray, $flags);
        foreach($internalArray as $offset=>$item)
        {
            $this->offsetSet($offset, $item);
        }

        return $sort;
    }

    /**
     * Sort values by custom function
     *
     * @link http://www.php.net/manual/en/function.usort.php
     *
     * @param string|array $func
     * @return bool
     */
    public function usort($func)
    {
        $internalArray = $this->toArray();
        $sort = usort($internalArray, $func);
        foreach($internalArray as $offset=>$item)
        {
            $this->offsetSet($offset, $item);
        }

        return $sort;
    }

    /**
     * Sort values while retaining indices.
     *
     * @link http://www.php.net/manual/en/function.asort.php
     *
     * @param int $flags
     * @return bool
     */
    public function asort($flags = SORT_REGULAR)
    {
        $internalArray = $this->toArray();
        $sort = asort($internalArray, $flags);
        foreach($internalArray as $offset=>$item)
        {
            $this->offsetSet($offset, $item);
        }

        return $sort;
    }

    /**
     * Reverse sort values while retaining indices
     *
     * @link http://www.php.net/manual/en/function.arsort.php
     *
     * @param int $flags
     * @return bool
     */
    public function arsort($flags = SORT_REGULAR)
    {
        $internalArray = $this->toArray();
        $sort = arsort($internalArray, $flags);
        foreach($internalArray as $offset=>$item)
        {
            $this->offsetSet($offset, $item);
        }

        return $sort;
    }

    /**
     * Sort values while preserving indices with custom function
     *
     * @link http://www.php.net/manual/en/function.uasort.php
     *
     * @param $func
     * @return bool
     */
    public function uasort($func)
    {
        $internalArray = $this->toArray();
        $sort = uasort($internalArray, $func);
        foreach($internalArray as $offset=>$item)
        {
            $this->offsetSet($offset, $item);
        }

        return $sort;
    }

    /**
     * (PHP 5 >= 5.1.0)
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize($this->toArray());
    }

    /**
     * (PHP 5 >= 5.1.0)
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized The string representation of the object.
     *
     * @return void
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->setSize(count($data));
        foreach($data as $i=>$d)
        {
            $this->offsetSet($i, $d);
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}