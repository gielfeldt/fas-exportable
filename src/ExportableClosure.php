<?php

namespace Fas\Exportable;

use Closure;
use Opis\Closure\ReflectionClosure;

class ExportableClosure implements ExportableInterface
{
    private Closure $closure;

    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
    }

    public function exportable(Exporter $exporter, $level = 0): string
    {
        return (new ReflectionClosure($this->closure))->getCode();
    }
}
