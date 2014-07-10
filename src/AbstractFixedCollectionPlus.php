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
        $currentSize = $this->getSize();
        for($i = 0; $i < $currentSize; $i++)
        {
            if ($this[$i] === $element)
                return true;
        }

        return false;
    }

    /**
     * Custom "contains" method
     *
     * @param callable $func
     * @return bool
     */
    public function exists(\Closure $func)
    {
        $currentSize = $this->getSize();
        for ($i = 0; $i < $currentSize; $i++)
        {
            if ((bool)$func($this[$i]) === true)
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
        /** @var \DCarbone\CollectionPlus\AbstractFixedCollectionPlus $new */
        $currentSize = $this->getSize();
        $new = new static($currentSize);

        for($i = 0; $i < $currentSize; $i++)
        {
            $new[$i] = $func($this[$i]);
        }

        return $new;
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
        /** @var \DCarbone\CollectionPlus\AbstractFixedCollectionPlus $new */
        $currentSize = $this->getSize();
        $new = new static($currentSize);
        $newSize = 0;

        if ($func !== null)
        {
            for ($i = 0; $i < $currentSize; $i++)
            {
                if ((bool)$func($this[$i]) !== false)
                    $new[$newSize++] = $this[$i];
            }
        }
        else
        {
            for ($i = 0; $i < $currentSize; $i++)
            {
                if ((bool)$this[$i] !== false)
                    $new[$newSize++] = $this[$i];
            }
        }
        $new->setSize($newSize);

        return $new;
    }

    /**
     * Return index of desired key
     *
     * @param mixed $value
     * @return int
     */
    public function indexOf($value)
    {
        $currentSize = $this->getSize();
        for ($i = 0; $i < $currentSize; $i++)
        {
            if ($this[$i] === $value)
                return $i;
        }

        return -1;
    }

    /**
     * Is this collection empty?
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->getSize() === 0;
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
}