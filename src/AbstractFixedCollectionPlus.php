<?php namespace DCarbone\CollectionPlus;

/**
 * Class AbstractFixedCollectionPlus
 * @package DCarbone\CollectionPlus
 */
class AbstractFixedCollectionPlus extends \SplFixedArray implements IFixedCollection
{
    /** @var int */
    private $size = 0;

    /**
     * @param int $size
     * @throws \InvalidArgumentException
     */
    public function __construct($size = 0)
    {
        if (!is_int($size))
            throw new \InvalidArgumentException('SplFixedArray::__construct() expects parameter 1 to be long, string given');

        parent::__construct($size);
        $this->size = $size;
    }

    /**
     * @param array $array
     * @param bool $save_indexes
     * @throws \InvalidArgumentException
     * @return AbstractFixedCollectionPlus
     */
    public static function fromArray($array, $save_indexes = true)
    {
        /** @var \DCarbone\CollectionPlus\AbstractFixedCollectionPlus $new  */
        if (!is_array($array))
            throw new \InvalidArgumentException('SplFixedArray::fromArray - "$array" must be an array, "'.gettype($array).'" given');

        if (!is_bool($save_indexes))
            throw new \InvalidArgumentException('SplFixedArray::fromArray - "$save_indexes" must be a boolean, "'.gettype($save_indexes).'" given');

        $count = count($array);

        // If an empty array is seen
        if ($count === 0)
            return new static;

        // If they have elected to NOT save indexes
        if (!$save_indexes)
        {
            $new = new static($count);
            $i = 0;
            while(key($array) !== null && ($current = current($array)) !== false)
            {
                $new[$i++] = $current;
                next($array);
            }

            return $new;
        }

        // If they DO want to preserve indexes

        // First, get array of keys, sort, and get last (largest) value
        $keys = array_keys($array);
        sort($keys);
        $last = end($keys);

        // If the last value is non-int or non-float, go ahead and throw exception
        if (!is_int($last) && !is_float($last))
            throw new \InvalidArgumentException('SplFixedArray::fromArray - array must contain only positive integer keys');

        // Create new instance
        $new = new static(($last > $count) ? $last + 1 : $count);

        // Populate instance.
        while(($key = key($array)) !== null && ($current = current($array)) !== false)
        {
            switch(true)
            {
                case (is_int($key)) :
                    $new[$key] = $current;
                    break;

                default :
                    throw new \InvalidArgumentException('SplFixedArray::fromArray - array must contain only positive integer keys');
            }
            next($array);
        }

        return $new;
    }

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
     * @return void
     */
    public function append($value)
    {
        $this->setSize(++$this->size);
        $this->offsetSet(($this->size - 1), $value);
    }

    /**
     * @param int $size
     * @return int
     */
    public function setSize($size)
    {
        $return = parent::setSize($size);
        $this->size = $size;
        return $return;
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
     * @throws \InvalidArgumentException
     * @return bool
     */
    public function exists($func)
    {
        if (!is_callable($func, false, $callable_name))
            throw new \InvalidArgumentException(__CLASS__.'::exists - Un-callable "$func" value seen!');

        if (strpos($callable_name, 'Closure::') !== 0)
            $func = $callable_name;

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
     * @throws \InvalidArgumentException
     * @return static
     */
    public function map($func)
    {
        if (!is_callable($func, false, $callable_name))
            throw new \InvalidArgumentException(__CLASS__.'::map - Un-callable "$func" value seen!');

        if (strpos($callable_name, 'Closure::') !== 0)
            $func = $callable_name;

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
     * @throws \InvalidArgumentException
     * @return static
     */
    public function filter($func = null)
    {
        if ($func !== null && !is_callable($func, false, $callable_name))
            throw new \InvalidArgumentException(__CLASS__.'::filter - Un-callable "$func" value seen!');

        /** @var \DCarbone\CollectionPlus\AbstractFixedCollectionPlus $new */
        $currentSize = $this->getSize();
        $new = new static($currentSize);
        $newSize = 0;

        if ($func !== null && isset($callable_name))
        {
            if (strpos($callable_name, 'Closure::') !== 0)
                $func = $callable_name;

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