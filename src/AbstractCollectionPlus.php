<?php namespace DCarbone\CollectionPlus;

/**
 * Class AbstractCollectionPlus
 * @package DCarbone\CollectionPlus
 */
abstract class AbstractCollectionPlus implements ICollectionPlus
{
    /** @var array */
    private $_storage = array();

    /** @var mixed */
    private $_firstKey = null;
    /** @var mixed */
    private $_lastKey = null;

    /** @var string */
    protected $iteratorClass = '\ArrayIterator';

    /**
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->_storage = $data;
        end($this->_storage);
        $this->_lastKey = key($this->_storage);
        reset($this->_storage);
        $this->_firstKey = key($this->_storage);
    }

    /**
     * Credit for this method goes to php5 dot man at lightning dot hu
     *
     * @link http://www.php.net/manual/en/class.arrayobject.php#107079
     *
     * This method allows you to call any of PHP's built-in array_* methods that would
     * normally expect an array parameter.
     *
     * Example: $myobj = new $concreteClass(array('b','c','d','e','a','z')):
     *
     * $myobj->array_keys();  returns array(0, 1, 2, 3, 4, 5)
     *
     * $myobj->array_merge(array('1', '2', '3', '4', '5')); returns array('b','c','d','e','a','z','1','2','3','4,'5');
     *
     * And so on.
     *
     * WARNING:  In utilizing call_user_func_array(), using this method WILL have an adverse affect on performance.
     * I recommend using this method only for development purposes.
     *
     * @param $func
     * @param $argv
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function __call($func, $argv)
    {
        if (!is_callable($func) || substr($func, 0, 6) !== 'array_')
            throw new \BadMethodCallException(__CLASS__.'->'.$func);

        return call_user_func_array($func, array_merge(array($this->_storage), $argv));
    }

    /**
     * @return array
     */
    public function array_keys()
    {
        return array_keys($this->_storage);
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
     * make this object an array!
     *
     * @return array
     */
    public function __toArray()
    {
        return $this->_storage;
    }

    /**
     * @param mixed $param
     * @return mixed
     * @throws \OutOfRangeException
     */
    public function &__get($param)
    {
        if (!$this->offsetExists($param))
            throw new \OutOfRangeException('No data element with the key "'.$param.'" found');

        return $this->_storage[$param];
    }

    /**
     * @param mixed $name
     * @param mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
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
        if (!is_array($dataSet) && !is_object($dataSet))
            throw new \InvalidArgumentException(__CLASS__.'::exchangeArray - "$dataSet" parameter expected to be array or object');

        if ($dataSet instanceof \stdClass)
            $dataSet = (array)$dataSet;
        else if ($dataSet instanceof self)
            $dataSet = $dataSet->__toArray();
        else if (is_object($dataSet) && is_callable(array($dataSet, 'getArrayCopy')))
            $dataSet = $dataSet->getArrayCopy();

        if (!is_array($dataSet))
            throw new \InvalidArgumentException(__CLASS__.'::exchangeArray - Could not convert "$dataSet" value of type "'.gettype($dataSet).'" to an array!');

        $storage = $this->_storage;
        $this->_storage = $dataSet;

        end($this->_storage);
        $this->_lastKey = key($this->_storage);
        reset($this->_storage);
        $this->_firstKey = key($this->_storage);
        return $storage;
    }


    /**
     * Set a value on this collection
     *
     * @param mixed $key
     * @param mixed $value
     * @return bool
     */
    public function set($key, $value)
    {
        $this->offsetSet($key, $value);
        return true;
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
            throw new \InvalidArgumentException(__CLASS__.'::exists - Un-callable "$func" value seen!');

        reset($this->_storage);

        if (strpos($callable_name, '::') !== false && strpos($callable_name, 'Closure') === false)
        {
            $exp = explode('::', $callable_name);
            while(($key = key($this->_storage)) !== null && ($value = current($this->_storage)) !== false)
            {
                if ($exp[0]::$exp[1]($key, $value))
                    return true;

                next($this->_storage);
            }
        }
        else
        {
            while(($key = key($this->_storage)) !== null && ($value = current($this->_storage)) !== false)
            {
                if ($func($key, $value))
                    return true;

                next($this->_storage);
            }
        }

        return false;
    }

    /**
     * Return index of desired key
     *
     * @param mixed $value
     * @return mixed
     */
    public function indexOf($value)
    {
        return array_search($value, $this->_storage, true);
    }

    /**
     * Remove and return an element
     *
     * @param $index
     * @return mixed|null
     */
    public function remove($index)
    {
        if (!isset($this->_storage[$index]) && !array_key_exists($index, $this->_storage))
            return null;

        $removed = $this->_storage[$index];
        unset($this->_storage[$index]);

        end($this->_storage);
        $this->_lastKey = key($this->_storage);
        reset($this->_storage);
        $this->_firstKey = key($this->_storage);

        return $removed;
    }

    /**
     * @param $element
     * @return bool
     */
    public function removeElement($element)
    {
        $key = array_search($element, $this->_storage, true);

        if ($key === false)
            return false;

        unset($this->_storage[$key]);

        end($this->_storage);
        $this->_lastKey = key($this->_storage);
        reset($this->_storage);
        $this->_firstKey = key($this->_storage);

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
        if (class_exists($class))
        {
            $this->iteratorClass = $class;
            return;
        }

        if (strpos($class, '\\') === 0)
        {
            $class = '\\' . $class;
            if (class_exists($class))
            {
                $this->iteratorClass = $class;
                return;
            }
        }

        throw new \InvalidArgumentException(__CLASS__.'::setIteratorClass - The iterator class does not exist');
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

        return new static(array_map($func, $this->_storage));
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

        if ($func === null)
            return new static(array_filter($this->_storage));

        if (strpos($callable_name, 'Closure::') !== 0)
            $func = $callable_name;

        return new static(array_filter($this->_storage, $func));
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
     * Return the first item from storage
     *
     * @return mixed
     */
    public function first()
    {
        if ($this->isEmpty())
            return null;

        return $this->_storage[$this->_firstKey];
    }

    /**
     * Return the last element from storage
     *
     * @return mixed
     */
    public function last()
    {
        if ($this->isEmpty())
            return null;

        return $this->_storage[$this->_lastKey];
    }

    /**
     * @return mixed|null
     */
    public function getFirstKey()
    {
        return $this->_firstKey;
    }

    /**
     * @return mixed|null
     */
    public function getLastKey()
    {
        return $this->_lastKey;
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
        $sort = sort($this->_storage, $flags);
        end($this->_storage);
        $this->_lastKey = key($this->_storage);
        reset($this->_storage);
        $this->_firstKey = key($this->_storage);
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
        $sort = rsort($this->_storage, $flags);
        end($this->_storage);
        $this->_lastKey = key($this->_storage);
        reset($this->_storage);
        $this->_firstKey = key($this->_storage);
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
        $sort = usort($this->_storage, $func);
        end($this->_storage);
        $this->_lastKey = key($this->_storage);
        reset($this->_storage);
        $this->_firstKey = key($this->_storage);
        return $sort;
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
        $sort = ksort($this->_storage, $flags);
        end($this->_storage);
        $this->_lastKey = key($this->_storage);
        reset($this->_storage);
        $this->_firstKey = key($this->_storage);
        return $sort;
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
        $sort = krsort($this->_storage, $flags);
        end($this->_storage);
        $this->_lastKey = key($this->_storage);
        reset($this->_storage);
        $this->_firstKey = key($this->_storage);
        return $sort;
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
        $sort = uksort($this->_storage, $func);
        end($this->_storage);
        $this->_lastKey = key($this->_storage);
        reset($this->_storage);
        $this->_firstKey = key($this->_storage);
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
        $sort = asort($this->_storage, $flags);
        end($this->_storage);
        $this->_lastKey = key($this->_storage);
        reset($this->_storage);
        $this->_firstKey = key($this->_storage);
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
        $sort = arsort($this->_storage, $flags);
        end($this->_storage);
        $this->_lastKey = key($this->_storage);
        reset($this->_storage);
        $this->_firstKey = key($this->_storage);
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
        $sort = uasort($this->_storage, $func);
        end($this->_storage);
        $this->_lastKey = key($this->_storage);
        reset($this->_storage);
        $this->_firstKey = key($this->_storage);
        return $sort;
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
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return (key($this->_storage) !== null && current($this->_storage) !== false);
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
     * Seeks to a position
     * @link http://php.net/manual/en/seekableiterator.seek.php
     * @param int $position The position to seek to.
     * 
     * @throws \OutOfBoundsException
     * @return void
     */
    public function seek($position)
    {
        if (!isset($this->_storage[$position]) && !array_key_exists($position, $this->_storage))
            throw new \OutOfBoundsException('Invalid seek position ('.$position.')');

        while (key($this->_storage) !== $position)
        {
            next($this->_storage);
        }
    }

    /**
     * (PHP 5 >= 5.0.0)
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset An offset to check for.
     * 
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
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset The offset to retrieve.
     * 
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        if (isset($this->_storage[$offset]) || array_key_exists($offset, $this->_storage))
            return $this->_storage[$offset];
        else
            return null;
    }

    /**
     * (PHP 5 >= 5.0.0)
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset The offset to assign the value to.
     * 
     * @param mixed $value The value to set.
     * 
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === null)
            $this->_storage[] = $value;
        else
            $this->_storage[$offset] = $value;

        end($this->_storage);
        $this->_lastKey = key($this->_storage);
        reset($this->_storage);
        $this->_firstKey = key($this->_storage);
    }

    /**
     * (PHP 5 >= 5.0.0)
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset The offset to unset.
     * 
     * @throws \OutOfBoundsException
     * @return void
     */
    public function offsetUnset($offset)
    {
        if (isset($this->_storage[$offset]) || array_key_exists($offset, $this->_storage))
            unset($this->_storage[$offset]);
        else
            throw new \OutOfBoundsException('Tried to unset undefined offset ('.$offset.')');

        end($this->_storage);
        $this->_lastKey = key($this->_storage);
        reset($this->_storage);
        $this->_firstKey = key($this->_storage);
    }

    /**
     * (PHP 5 >= 5.1.0)
     * Count elements of an object
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
     * (PHP 5 >= 5.1.0)
     * String representation of object
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
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized The string representation of the object.
     * 
     * @return void
     */
    public function unserialize($serialized)
    {
        $this->_storage = unserialize($serialized);

        end($this->_storage);
        $this->_lastKey = key($this->_storage);
        reset($this->_storage);
        $this->_firstKey = key($this->_storage);
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->_storage;
    }
}
