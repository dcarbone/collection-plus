<?php namespace DCarbone;

/**
 * Class AbstractCollectionPlus
 * @package DCarbone
 */
abstract class AbstractCollectionPlus implements CollectionPlusInterface
{
    /** @var array */
    private $_storage = array();

    /** @var bool */
    private $_modified = true;

    /** @var string|int */
    private $_lastKey;
    /** @var string|int */
    private $_firstKey;

    /** @var string */
    protected $iteratorClass = '\\ArrayIterator';

    /**
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->_storage = $data;
    }

    /**
     * @param array $data
     * @return \DCarbone\CollectionPlusInterface
     */
    protected function initNew(array $data = array())
    {
        return new static($data);
    }

    /**
     * @param mixed $name
     * @return mixed
     * @throws \OutOfBoundsException
     */
    function &__get($name)
    {
        if ($this->offsetExists($name))
            return $this->_storage[$name];

        throw new \OutOfBoundsException(sprintf('Key "%s" does not exist in this collection.', $name));
    }

    /**
     * @param string|int $name
     * @param mixed $value
     */
    function __set($name, $value)
    {
        $this->_modified = true;
        $this->offsetSet($name, $value);
    }

    /**
     * @return array
     */
    public function keys()
    {
        return array_keys($this->_storage);
    }

    /**
     * @return array
     */
    public function values()
    {
        return array_values($this->_storage);
    }

    /**
     * Executes array_search on internal storage array.
     *
     * Please refer to PHP docs for usage information.
     * @link http://php.net/manual/en/function.array-search.php
     *
     * @param mixed $value
     * @param bool|false $strict
     * @return mixed
     */
    public function search($value, $strict = false)
    {
        return array_search($value, $this->_storage, $strict);
    }

    /**
     * @return mixed
     */
    public function firstValue()
    {
        if ($this->isEmpty())
            return null;

        if ($this->_modified)
            $this->_updateFirstLastKeys();

        return $this->_storage[$this->_firstKey];
    }

    /**
     * @return mixed
     */
    public function lastValue()
    {
        if ($this->isEmpty())
            return null;

        if ($this->_modified)
            $this->_updateFirstLastKeys();

        return $this->_storage[$this->_lastKey];
    }

    /**
     * @return int|null|string
     */
    public function firstKey()
    {
        if ($this->isEmpty())
            return null;

        if ($this->_modified)
            $this->_updateFirstLastKeys();

        return $this->_firstKey;
    }

    /**
     * @return int|null|string
     */
    public function lastKey()
    {
        if ($this->isEmpty())
            return null;

        if ($this->_modified)
            $this->_updateFirstLastKeys();

        return $this->_lastKey;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return 0 === count($this);
    }

    /**
     * Moves internal storage array pointer to last index and returns value
     *
     * @return mixed
     */
    public function end()
    {
        return end($this->_storage);
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return $this->_storage;
    }

    /**
     * (PHP 5 >= 5.0.0)
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return current($this->_storage);
    }

    /**
     * (PHP 5 >= 5.0.0)
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        next($this->_storage);
    }

    /**
     * (PHP 5 >= 5.0.0)
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return key($this->_storage);
    }

    /**
     * (PHP 5 >= 5.0.0)
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean
     *
     * The return value will be casted to boolean and then evaluated.
     */
    public function valid()
    {
        return !(null === key($this->_storage) && false === current($this->_storage));
    }

    /**
     * (PHP 5 >= 5.0.0)
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        reset($this->_storage);
    }

    /**
     * (PHP 5 >= 5.1.0)
     * Seeks to a position
     * @link http://php.net/manual/en/seekableiterator.seek.php
     * @param int|string $position The position to seek to.
     * @return void
     */
    public function seek($position)
    {
        reset($this->_storage);
        while (($key = key($this->_storage)) !== null && $key !== $position)
        {
            next($this->_storage);
        }
    }

    /**
     * (PHP 5 >= 5.0.0)
     * Whether a offset exists
     * @internal
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset An offset to check for.
     * @return boolean true on success or false on failure.
     *
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return isset($this->_storage[$offset]) || array_key_exists($offset, $this->_storage);
    }

    /**
     * (PHP 5 >= 5.0.0)
     * Offset to retrieve
     * @internal
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset The offset to retrieve.
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset))
            return $this->_storage[$offset];

        trigger_error(vsprintf(
            '%s::offsetGet - Requested offset "%s" does not exist in this collection.',
            array(get_class($this), $offset)
        ), E_USER_NOTICE);

        return null;
    }

    /**
     * (PHP 5 >= 5.0.0)
     * Offset to set
     * @internal
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset The offset to assign the value to.
     * @param mixed $value  The value to set.
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->_modified = true;
        if (null === $offset)
            $this->_storage[] = $value;
        else
            $this->_storage[$offset] = $value;
    }

    /**
     * (PHP 5 >= 5.0.0)
     * Offset to unset
     * @internal
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset The offset to unset.
     * @return void
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset))
        {
            $this->_modified = true;
            unset($this->_storage[$offset]);
        }
    }

    /**
     * (PHP 5 >= 5.1.0)
     * Count elements of an object
     * @internal
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     *
     * The return value is cast to an integer.
     */
    public function count()
    {
        return count($this->_storage);
    }

    /**
     * echo this object!
     *
     * @return string
     */
    public function __toString()
    {
        return get_class($this);
    }

    /**
     * @deprecated Use "getArrayCopy" instead
     * @return array
     */
    public function __toArray()
    {
        return $this->getArrayCopy();
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->_storage;
    }

    /**
     * This method was inspired by Zend Framework 2.2.x PhpReferenceCompatibility class
     *
     * @link https://github.com/zendframework/zf2/blob/release-2.2.6/library/Zend/Stdlib/ArrayObject/PhpReferenceCompatibility.php#L179
     *
     * @param $dataSet
     * @return array
     * @throws \InvalidArgumentException
     */
    public function exchangeArray($dataSet)
    {
        if (is_object($dataSet))
        {
            switch(true)
            {
                case is_callable(array($dataSet, 'getArrayCopy'), false):
                    $dataSet = $dataSet->getArrayCopy();
                    break;
                case is_callable(array($dataSet, 'toArray'), false):
                    $dataSet = $dataSet->toArray();
                    break;
                case is_callable(array($dataSet, '__toArray'), false):
                    $dataSet = $dataSet->__toArray();
                    break;
                case ($dataSet instanceof \stdClass):
                    $dataSet = (array)$dataSet;
                    break;

                default:
                    throw new \InvalidArgumentException(vsprintf(
                        '%s - Unable to exchange data with object of class "%s".',
                        array(get_class($this), get_class($dataSet)))
                    );
            }
        }

        if (is_array($dataSet))
        {
            $prevStorage = $this->_storage;
            $this->_storage = $dataSet;
            $this->_modified = true;
            return $prevStorage;
        }

        throw new \InvalidArgumentException(vsprintf(
            '%s::exchangeArray expects parameter 1 to be array or object, "%s" seen.',
            array(get_class($this), gettype($dataSet))
        ));
    }

    /**
     * Set a value on this collection
     *
     * @param mixed $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value)
    {
        $this->offsetSet($key, $value);
    }

    /**
     * Append a value
     *
     * @param mixed $value
     * @return void
     */
    public function append($value)
    {
        $this->offsetSet(null, $value);
    }

    /**
     * Try to determine if an identical element is already in this collection
     *
     * @param mixed $element
     * @return bool
     */
    public function contains($element)
    {
        return in_array($element, $this->_storage, true);
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
            throw new \InvalidArgumentException(get_class($this).'::exists - Un-callable "$func" value seen!');

        foreach($this->_storage as $key => $value)
        {
            if (call_user_func($func, $key, $value))
                return true;
        }

        return false;
    }

    /**
     * @deprecated Use "search" method instead
     * @param mixed $value
     * @return mixed
     */
    public function indexOf($value)
    {
        return $this->search($value, true);
    }

    /**
     * Remove and return an element
     *
     * @param $index
     * @return mixed|null
     */
    public function remove($index)
    {
        if (isset($this->_storage[$index]) || array_key_exists($index, $this->_storage))
        {
            $this->_modified = true;
            $removed = $this->_storage[$index];
            unset($this->_storage[$index]);
            return $removed;
        }

        return null;
    }

    /**
     * @param mixed $element
     * @return bool
     */
    public function removeElement($element)
    {
        $key = array_search($element, $this->_storage, true);

        if ($key === false)
            return false;

        unset($this->_storage[$key]);
        $this->_modified = true;

        return true;
    }

    /**
     * Get an Iterator instance for this data set
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        $class = $this->iteratorClass;
        return new $class($this->_storage);
    }

    /**
     * @return string
     */
    public function getIteratorClass()
    {
        return $this->iteratorClass;
    }

    /**
     * Sets the iterator classname for the ArrayObject
     *
     * @param  string $class
     * @throws \InvalidArgumentException
     * @return void
     */
    public function setIteratorClass($class)
    {
        if (strpos($class, '\\') !== 0)
            $class = sprintf('%s%s', '\\', $class);

        if (class_exists($class, true))
        {
            $this->iteratorClass = $class;
            return;
        }

        throw new \InvalidArgumentException(vsprintf(
            '%s::setIteratorClass - Class "%s" is not defined.',
            array(
                get_class($this),
                $class))
        );
    }

    /**
     * Applies array_map to this collection, and returns a new object.
     *
     * @link http://us1.php.net/array_map
     *
     * The scope "static" is used so that an instance of the extended class is returned.
     *
     * @param callable $func
     * @throws \InvalidArgumentException
     * @return \DCarbone\CollectionPlusInterface
     */
    public function map($func)
    {
        if (is_callable($func, false))
            return $this->initNew(array_map($func, $this->_storage));

        throw new \InvalidArgumentException(vsprintf(
            '%s::map - Un-callable "$func" value seen!',
            array(get_class($this)))
        );
    }

    /**
     * Applies array_filter to internal collection, returns new instance with resulting values.
     *
     * @link http://www.php.net/manual/en/function.array-filter.php
     *
     * Inspired by:
     *
     * @link http://www.doctrine-project.org/api/common/2.3/source-class-Doctrine.Common.Collections.ArrayCollection.html#377-387
     *
     * @param callable $func
     * @throws \InvalidArgumentException
     * @return \DCarbone\CollectionPlusInterface
     */
    public function filter($func = null)
    {
        if (null === $func)
            return $this->initNew(array_filter($this->_storage));

        if (is_callable($func, false))
            return $this->initNew(array_filter($this->_storage, $func));

        throw new \InvalidArgumentException(vsprintf(
            '%s::filter - Un-callable "$func" value seen!',
            array(get_class($this)))
        );
    }

    /**
     * Return the first item from storage
     *
     * @deprecated Use "firstValue" method instead
     * @return mixed
     */
    public function first()
    {
        return $this->firstValue();
    }

    /**
     * Return the last element from storage
     *
     * @deprecated Use "lastValue" instead
     * @return mixed
     */
    public function last()
    {
        return $this->lastValue();
    }

    /**
     * @deprecated Use "firstKey" instead
     * @return mixed|null
     */
    public function getFirstKey()
    {
        return $this->firstKey();
    }

    /**
     * @deprecated use "lastKey" instead
     * @return mixed|null
     */
    public function getLastKey()
    {
        return $this->lastKey();
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
        $this->_modified = true;
        return sort($this->_storage, $flags);
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
        $this->_modified = true;
        return rsort($this->_storage, $flags);
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
        $this->_modified = true;
        return usort($this->_storage, $func);
    }

    /**
     * Sort by keys
     *
     * @link http://www.php.net/manual/en/function.ksort.php
     *
     * @param int $flags
     * @return bool
     */
    public function ksort($flags = SORT_REGULAR)
    {
        $this->_modified = true;
        return ksort($this->_storage, $flags);
    }

    /**
     * Reverse sort by keys
     *
     * @link http://www.php.net/manual/en/function.krsort.php
     *
     * @param int $flags
     * @return bool
     */
    public function krsort($flags = SORT_REGULAR)
    {
        $this->_modified = true;
        return krsort($this->_storage, $flags);
    }

    /**
     * Sort by keys with custom function
     *
     * http://www.php.net/manual/en/function.uksort.php
     *
     * @param string|array $func
     * @return bool
     */
    public function uksort($func)
    {
        $this->_modified = true;
        return uksort($this->_storage, $func);
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
        $this->_modified = true;
        return asort($this->_storage, $flags);
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
        $this->_modified = true;
        return arsort($this->_storage, $flags);
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
        $this->_modified = true;
        return uasort($this->_storage, $func);
    }

    /**
     * (PHP 5 >= 5.1.0)
     * Returns if an iterator can be created for the current entry.
     * @link http://php.net/manual/en/recursiveiterator.haschildren.php
     * @return bool true if the current entry can be iterated over, otherwise returns false.
     */
    public function hasChildren()
    {
        return ($this->valid() && is_array(current($this->_storage)));
    }

    /**
     * (PHP 5 >= 5.1.0)
     * Returns an iterator for the current entry.
     * @link http://php.net/manual/en/recursiveiterator.getchildren.php
     * @return \RecursiveIterator An iterator for the current entry.
     */
    public function getChildren()
    {
        return current($this->_storage);
    }

    /**
     * (PHP 5 >= 5.1.0)
     * String representation of object
     * @internal
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize($this->_storage);
    }

    /**
     * (PHP 5 >= 5.1.0)
     * Constructs the object
     * @internal
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized The string representation of the object.
     * @return void
     */
    public function unserialize($serialized)
    {
        $this->_storage = unserialize($serialized);
        $this->_modified = true;
    }

    /**
     * Update internal references to first and last keys in collection
     */
    private function _updateFirstLastKeys()
    {
        end($this->_storage);
        $this->_lastKey = key($this->_storage);
        reset($this->_storage);
        $this->_firstKey = key($this->_storage);

        $this->_modified = false;
    }
}