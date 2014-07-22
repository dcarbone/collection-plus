# FixedCollectionPlus

This class is an extension of the built-in [SplFixedArray](http://php.net/manual/en/class.splfixedarray.php) class.

It is designed to provide similar functionality to the [AbstractCollectionPlus](COLLECTION.md) class, while taking advantage of the performance
and memory usage benefits of the SplFixedArray class

## Basics

As stated above, this class _extends_ the base ``` SplFixedArray ``` class, and as such all of the public methods provided by the base class are available here.

## Extension

[Click here](src/IFixedCollection.php) to see what methods I have added to the base class

The usage of this class requires a certain level of understanding about how the based [SplFixedArray](http://php.net/manual/en/class.splfixedarray.php) functions.

If you run into any specific issue or have a suggestion on how I can improve this class, please let me know.