# DataFlow Core

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/vincenttouzet/DataFlow-Core/badges/quality-score.png?s=2771d9415f76506ededfec4790bb69b0cef62ba2)](https://scrutinizer-ci.com/g/vincenttouzet/DataFlow-Core/)
[![Code Coverage](https://scrutinizer-ci.com/g/vincenttouzet/DataFlow-Core/badges/coverage.png?s=3168f2e9c39491a69e32597aaa3e92628c6a1a2f)](https://scrutinizer-ci.com/g/vincenttouzet/DataFlow-Core/)
[![Build Status](https://travis-ci.org/vincenttouzet/DataFlow-Core.svg?branch=master)](https://travis-ci.org/vincenttouzet/DataFlow-Core)

DataFlow is a library based on [**sonata/exporter**][1] to aggregate or merge multiple data sources and export to multiple writers.

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

You can also add [**mappers**][2] and [**filters**][3]

[1]: https://github.com/sonata-project/exporter
[2]: docs/mappers.md
[3]: docs/filters.md
