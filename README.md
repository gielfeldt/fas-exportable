[![Build Status](https://github.com/gielfeldt/fas-exportable/actions/workflows/php.yml/badge.svg)][1]
[![Test Coverage](https://img.shields.io/endpoint?url=https://gist.githubusercontent.com/gielfeldt/e9c4f6129cef70b1a3c998fe2c773aaf/raw/fas-exportable__main.json)][2]

[![Latest Stable Version](https://poser.pugx.org/fas/exportable/v/stable.svg)][4]
[![Latest Unstable Version](https://poser.pugx.org/fas/exportable/v/unstable.svg)][4]
[![Dependency Status](https://www.versioneye.com/user/projects/58ed39a526a5bb0038e422f7/badge.svg?style=flat)][5]
[![License](https://poser.pugx.org/fas/exportable/license.svg)][6]
[![Total Downloads](https://poser.pugx.org/fas/exportable/downloads.svg)][4]


# Installation

```bash
composer require fas/exportable
```

## Optional closure export support
```bash
composer require opis/closure:^3.6
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
