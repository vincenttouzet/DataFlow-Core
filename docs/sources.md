# Sources

You may export data from various sources:

* PHP Array
* CSV
* Doctrine Query (ORM & ODM supported)
* PDO Statement
* Propel Collection
* PHP Iterator instance
* XML
* Excel XML
* Sitemap (Takes another iterator)

You may also create your own. To do so, simply create a class that implements ``DataFlow\Source\SourceIteratorInterface`` and use the ``DataFlow\Source\SourceIterator`` Trait.