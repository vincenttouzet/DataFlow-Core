# Filters

You can use filters on Source and/or writers.

## Source Filters

For example you have the following data source

| username | firstname | name |
|----------|-----------|------|
| johndoe  | John      | Doe  |
| vincenttouzet | Vincent | Touzet |


If you want to export lines where username equals ``vincenttouzet`` the first step is to create a filter...

```php
<?php
use DataFlow\Filter\EqualFilter;

$filter = new EqualFilter('username', 'vincenttouzet');
```

... and to add this filter to the source.

```php
$source->addFilter($filter);
```

You can add multiple filters and when exporting the source, only lines that match all filters will be exported.

## Writer filter

It's exactly the same that for a source

```php
use DataFlow\Filter\EqualFilter;

$filter = new EqualFilter('username', 'vincenttouzet');

$writer->addFilter($filter);
```

## Custom Filter

You can add your custom filter:

### Directly as a callable

```php
$source->addFilter(
    function (array $data) {
        // must return true or false
    }
);
```

### Create a new filter

A filter is a callable, so you just have to create a new class with the ``__invoke`` method.

```php
class MyFilter
{
    public function __invoke(array $data)
    {
        return true;
    }
}
...

$filter = new MyFilter();
$source->addFilter($filter);

```

## Available filters

* [*Equal*][0]
* [*PregMatch*][1]

[0] filters/Equal.md
[1] filters/PregMatch.md