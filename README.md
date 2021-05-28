![Build Status](https://github.com/gielfeldt/fas-exportable/actions/workflows/php.yml/badge.svg)
![Test Coverage](https://img.shields.io/endpoint?url=https://gist.githubusercontent.com/gielfeldt/e9c4f6129cef70b1a3c998fe2c773aaf/raw/fas-exportable__main.json)

![Latest Stable Version](https://poser.pugx.org/fas/exportable/v/stable.svg)
![Latest Unstable Version](https://poser.pugx.org/fas/exportable/v/unstable.svg)
![License](https://poser.pugx.org/fas/exportable/license.svg)
![Total Downloads](https://poser.pugx.org/fas/exportable/downloads.svg)


# Installation

```bash
composer require fas/exportable
```

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
