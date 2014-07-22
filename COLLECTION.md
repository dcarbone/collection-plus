# CollectionPlus

This class most closely resembles a typical PHP "Collection" class.

## Interfaces

The following interfaces are implemented in this collection class:

- <a href="http://php.net/manual/en/class.arrayaccess.php" target="_blank">\ArrayAccess</a>
- <a href="http://php.net/manual/en/class.countable.php" target="_blank">\Countable</a>
- <a href="http://us2.php.net/RecursiveIterator" target="_blank">\RecursiveIterator</a>
- <a href="http://us2.php.net/manual/en/class.seekableiterator.php" target="_blank">\SeekableIterator</a>
- <a href="http://us1.php.net/manual/en/class.serializable.php" target="_blank">\Serializable</a>
- <a href="http://php.net/manual/en/class.jsonserializable.php" target="_blank">\JsonSerializable</a>

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

## Available Methods:

[Click here](src/ICollectionPlus.php) to have a look at what public methods are available on this class.

## Some Usage Guidelines

If you're used to using arrays in PHP, you've probably done something like this:

```php
$array = array(
    'sub-array' => array('value1')
);

$array['sub-array'][] = 'value2';

var_export($array);

/* Results in:
array (
  'sub-array' =>
  array (
    0 => 'value1',
    1 => 'value2',
  ),
)
*/
```

However, if you try to do this with a class implementing ``` \ArrayAccess ```, you'll see the following message:

```php
$class = new \DCarbone\CollectionPlus\BaseCollectionPlus(
    array(
        'sub-array' => array('value1'),
    )
);

$class['sub-array'][] = 'value2';

// Produces E_NOTICE:
// Notice: Indirect modification of overloaded element of DCarbone\CollectionPlus\BaseCollectionPlus has no effect
```

There are a few ways around this.

First, you could do this:
```php
$current = $class['sub-array'];
$current[] = 'value2';
$class['sub-array'] = $current;

var_export($class->__toArray());

/* Produces:
array (
  'sub-array' =>
  array (
    0 => 'value1',
    1 => 'value2',
  ),
)
*/
```

For my money, however, I prefer to do this:
```php
$class->{'sub-array'}[] = 'value2';

var_export($class->__toArray());

/* Produces:
array (
  'sub-array' =>
  array (
    0 => 'value1',
    1 => 'value2',
  ),
)
*/
```

Both methods work just fine, however.

## JSON Serializing
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