# PregMatch filter

The ``PregMatch`` filter test that the given column match the given pattern.

```php
use DataFlow\Filter\PregMatchFilter;

$filter = new PregMatchFilter('my_column', '/\d+/');
```
