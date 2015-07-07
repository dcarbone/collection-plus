# Changelog

## 3.0

### Big Changes
- Moving all "Fixed" collection classes to their own repository [here](https://github.com/dcarbone/fixed-collection-plus).
- Shifting root namespace from "DCarbone\CollectionPlus" to just "DCarbone"
- Renaming "BaseCollectionPlus" to just "CollectionPlus"
- Renaming "ICollectionPlus" to "CollectionPlusInterface"

### Minor Changes
- "set" and "append" methods no longer return any value
- Refactoring some of my dumber code.

### Additions
- Adding "values" method, which returns an array with integer keys containing all values in collection

### Deprecation
- Deprecating method "__toArray" in favor of "getArrayCopy" to make usage more similar to [ArrayObject](http://php.net/manual/en/class.arrayobject.php)
