# Changelog

## 3.1

### Big Changes
- Near-complete rewrite of test cases, still requires more work

### Bug Fixes
- "seek" now properly resets internal storage pointer before attempting to find key
- Few other minor things

### Deprecation
- "first" deprecated in favor of "firstValue"
- "last" deprecated in favor of "lastValue"
- "getFirstKey" deprecated in favor of "firstKey"
- "getLastKey" deprecated in favor of "lastKey"
- "indexOf" deprecated in favor of "search"

### Need To Do
- Improve "seek" implementation

## 3.0

### Big Changes
- Moving all "Fixed" collection classes to their own repository [here](https://github.com/dcarbone/fixed-collection-plus).
- Shifting root namespace from "DCarbone\CollectionPlus" to just "DCarbone"
- Renaming "BaseCollectionPlus" to just "CollectionPlus"
- Renaming "ICollectionPlus" to "CollectionPlusInterface"

### Minor Changes
- "set" and "append" methods no longer return any value
- Refactoring some of my dumber code.
- "__get" now throws OutOfBoundsException rather than OutOfRangeException
- Exception no longer thrown when unsetting invalid key, just does nothing.

### Additions
- Adding "values" method, which returns an array with integer keys containing all values in collection

### Deprecation
- Deprecating method "__toArray" in favor of "getArrayCopy" to make usage more similar to [ArrayObject](http://php.net/manual/en/class.arrayobject.php)
