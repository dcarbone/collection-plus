collection-plus
===============

A PHP 5.3+ Collection implementation that takes inspiration from multiple sources

### CollectionPlus

Every PHP framework out there defines it's own Collection-style class, and each has it's own set of nice features.  The point of this class
was to bring together as many of those collections as possible into a single class so I could take advantage of the genius
of others while adding my own flair.

## Inspiration:

- <a href="http://www.doctrine-project.org/api/common/2.4/source-class-Doctrine.Common.Collections.ArrayCollection.html" target="_blank">Doctrine ArrayCollection</a>
- <a href="https://github.com/zendframework/zf2/blob/release-2.2.6/library/Zend/Stdlib/ArrayObject/PhpReferenceCompatibility.php#L179" target="_blank">Zend ArrayObject</a>
- Various comments in the ArrayObject doc section of php.net

## PHP Interface Implementations

The following interfaces are implemented in this collection class:

- <a href="http://php.net/manual/en/class.arrayaccess.php" target="_blank">\ArrayAccess</a>
- <a href="http://php.net/manual/en/class.countable.php" target="_blank">\Countable</a>
- <a href="http://us2.php.net/RecursiveIterator" target="_blank">\RecursiveIterator</a>
- <a href="http://us2.php.net/manual/en/class.seekableiterator.php" target="_blank">\SeekableIterator</a>
- <a href="http://us1.php.net/manual/en/class.serializable.php" target="_blank">\Serializable</a>
- <a href="http://php.net/manual/en/class.jsonserializable.php" target="_blank">\JsonSerializable</a>

## Inclusion in your Composer application

```json
"require" : {
    "dcarbone/collection-plus" : "1.1.*"
}
```

#### Example

```php

use DCarbone\CollectionPlus\AbstractCollectionPlus;

class Parent extends AbstractCollectionPlus {}
class Child extends AbstractCollectionPlus {}

$sasha = new Child(array(
    'age' => 7,
    'name' => 'Sasha',
    'favoriteFood' => 'French Fries'
));

$peter = new Child(array(
    'age' => 15,
    'name' => 'Peter',
    'favoriteFood' => 'Salmon'
));

$parent = new Parent();

$parent->set('Peter', $peter);
$parent->set('Sasha', $sasha);

var_dump($parent->array_keys());
/*
array(2) {
    [0] => string(5) "Peter"
    [1] => string(5) "Sasha"
}
*/

$parent->rsort();

var_dump($parent->array_keys());
/*
array(2) {
    [0] => string(5) "Sasha"
    [1] => string(5) "Peter"
}
*/

$daniel = array(
    "age" => 27,
    "name" => "Daniel",
    "favoriteFood" => "Spaghetti"
);

$parent->append($daniel);

var_dump($parent->array_keys());
/*
array(3) {
    [0] => string(5) "Sasha"
    [1] => string(5) "Peter"
    [2] => int(0)
}
*/
```

#### Available Methods

```php
// Creates instance and defines default data
public __construct (array $data = array())

// Returns keys present on this collection
public array_keys()

// Set a value in the collection using a scalar key and any value
public set (scalar $key, mixed $value)

// Append any value to this collection.  Will receive an integer key
public append (mixed $value)

// Uses strict comparison.
// For more information on comparing objects, see here:
// http://php.net/manual/en/language.oop5.object-comparison.php
public contains (mixed $element)

// Accepts a closure function to perform a custom contains() call
// Closure params: $closure($key, $value)
public exists (\Closure $func)

// Returns index of value or false on failure / non-existence
public indexOf (mixed $value)

// Remove element from collection based on key.  Returns removed element or null.
public remove (scalar $key)

// Remove element from collection based on element.  Returns true on success, false on failure / non-existence
public removeElement (mixed $element)

// Returns new \ArrayIterator instance with data from collection
public getIterator ()

// Return new instance of extended class after applying array_map to internal contents
public map (\Closure $func)

// Return new instance of extended class after applying array_filter to internal contents
public filter (\Closure $func = null)

// Is this collection empty?
public isEmpty ()

// Returns first item in collection or null if empty
public first ()

// Returns last item in collection or null if empty
public last ()

// Sort internal data by value.  Accepts PHP SORT_X flags
public sort (int $flags)

// Reverse sort internal data by value.
public rsort (int $flags)

// Sort by values with custom sort function.
public usort (mixed $func)

// Sort by keys
public ksort (int $flags)

// Reverse sort by keys
public krsort (int $flags)

// Sort by keys with custom sort function
public uksort (mixed $func)

// Sort by values preserving indices
public asort (int $flags)

// Reverse sort by values preserving indices
public arsort (int $flags)

// Sort by values preserving indices with custom sort function
public uasort (mixed $func)

```

You may also use this class as a glorified array if you are used to that kind of thing.

For instance, this works:

```php
foreach($parent as $name=>$child)
{
    echo $name.' : ';
    echo $child['age'];
    echo '<br>';
}
/*
    Sasha : 7
    Peter : 15
    0 : 27
*/
```

However you may NOT use foreach by reference:

```php
foreach($parent as $name=>&$child) {} // Doesn't work!
```

If you wish to modify the values of the contents within a foreach loop, you can do this:

```php
foreach($parent->array_keys() as $key)
{
    $child = &$parent[$key];
}
```

If you are using PHP >= 5.4.0, you may also call this:

```php
$json = json_encode($parent);
```

Note that this will only work if all child objects also implement the <a href="http://php.net/manual/en/class.jsonserializable.php">JsonSerializable</a> interface.

#### PHP 5.3.x USERS!

I have added a custom JsonSerializable interface to maintain backward compatibility, but you must call this:

```php
$json = json_encode($parent->jsonSerialize());
```
