collection-plus
===============

**Build Statuses**:
- master : [![Build Status](https://travis-ci.org/dcarbone/collection-plus.svg?branch=master)](https://travis-ci.org/dcarbone/collection-plus)

A PHP 5.3.3+ Collection implementation that takes inspiration from multiple sources

Every PHP framework out there defines it's own Collection-style class, and each has it's own set of nice features.  The point of this class
was to bring together as many of those collections as possible into a single class so I could take advantage of the genius
of others while adding my own flair.

## Inclusion in your Composer application

```json
"require" : {
    "dcarbone/collection-plus" : "2.0.*"
}
```

## Inspiration:

- <a href="http://www.doctrine-project.org/api/common/2.4/source-class-Doctrine.Common.Collections.ArrayCollection.html" target="_blank">Doctrine ArrayCollection</a>
- <a href="https://github.com/zendframework/zf2/blob/release-2.2.6/library/Zend/Stdlib/ArrayObject/PhpReferenceCompatibility.php#L179" target="_blank">Zend ArrayObject</a>
- Various comments in the ArrayObject doc section of php.net

## Available Classes:
- [AbstractCollectionPlus](COLLECTION.md)
- [AbstractFixedCollectionPlus](FIXEDCOLLECTION.md)

## Comments / Suggestions / Criticisms

If you find something broken with this library, or know of a way in which I could do something better, please let me know!  Little is accomplished by developing in a vacuum.
