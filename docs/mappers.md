# Mappers

You can use mappers on Source and/or writers.

## Source mappers

For example you have the two following data sources

| username | firstname | name |
|----------|-----------|------|
| johndoe  | John      | Doe  |
| vincenttouzet | Vincent | Touzet |


| login    | email | age |
|----------|-------|-----|
| johndoe  | johndoe@domain.com | 42 |
| vincenttouzet | vincent.touzet@gmail.com | 26 |

If you want to merge this two data sources you have to add a mapper to translate ``login`` to ``username``

The first step is to create a mapper

```php
<?php
use DataFlow\Mapper\Mapper;

$mapper = new Mapper();
$mapper->addMapping('login', 'username');
```

and to add this mapper to the source.

```php
$source = new CsvSourceIterator('table2.csv');
$source->addMapper($mapper);
```

And that's all. When exporting the source the ``login`` will be renamed ``username`` and other columns remain unchanged.

## Writer mappers

You can also use a mapper on a writer.

If we merge the previous example we have :

| username | firstname | name | email | age |
|----------|-----------|------|-------|-----|
| johndoe  | John      | Doe  | johndoe@domain.com | 42 |
| vincenttouzet | Vincent | Touzet | vincent.touzet@gmail.com | 26 |

If you have a custom writer that does not recognize the ``name`` you can then use a mapper

```php
use DataFlow\Mapper\Mapper;

$mapper = new Mapper();
$mapper->addMapping('name', 'lastname');

$writer->addMapper($mapper);
```
