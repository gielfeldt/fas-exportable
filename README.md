

# Usage

## Closures

```php
<?php

require './vendor/autoload.php';

use Fas\Exportable\Exporter;

$exporter = new Exporter();

$data = [
    'somefunc' => static function () {
        return 'test';
    }
];

$output = $exporter->export($data);

print "$output\n";
```

**output:**
```
[
  'somefunc' => static function () {
        return 'test';
    }
]
```

## Custom objects

```php
<?php

require './vendor/autoload.php';

use Fas\Exportable\ExportableInterface;
use Fas\Exportable\Exporter;

class UpperCase implements ExportableInterface
{
    private string $str;

    public function __construct(string $str)
    {
        $this->str = $str;
    }

    public function exportable(Exporter $exporter, $level = 0): string
    {
        return var_export(strtoupper($this->str), true);
    }
}

$exporter = new Exporter();

$data = [
    'somekey' => new UpperCase('somevalue'),
];

$output = $exporter->export($data);

print "$output\n";
```

**output:**
```
[
  'somekey' => 'SOMEVALUE'
]
```
