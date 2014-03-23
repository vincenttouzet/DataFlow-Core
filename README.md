# DataFlow Core

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/vincenttouzet/DataFlow-Core/badges/quality-score.png?s=2771d9415f76506ededfec4790bb69b0cef62ba2)](https://scrutinizer-ci.com/g/vincenttouzet/DataFlow-Core/)


DataFlow is a library base on [**sonata/exporter**][1] to aggregate or merge multiple data sources and export to multiple writers.

## Usage

```php
<?php

$handler = new \DataFlow\Handler();
// add sources
$source1 = new \DataFlow\Source\CsvSourceIterator('data1.csv');
$source2 = new \DataFlow\Source\CsvSourceIterator('data2.csv');
$handler->addSource($source1);
$handler->addSource($source2);
// add writer
$writer = new \DataFlow\Source\CsvWriter('aggregate.csv');
$handler->addWriter($writer);

// aggregate sources
$handler->aggregate();
// or merge based on primary column
// $handler->merge('primary_column_name');

```


[1]: https://github.com/sonata-project/exporter
