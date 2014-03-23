# DataFlow Core

DataFlow is a library to aggregate or merge multiple data sources and export to multiple writers.

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

