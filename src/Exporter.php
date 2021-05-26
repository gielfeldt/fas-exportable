<?php

namespace Fas\Exportable;

use Closure;
use Fas\Exportable\ExportableInterface;

class Exporter implements ResolverInterface
{
    private string $indent;
    private string $eol;

    public function __construct(?ResolverInterface $resolver = null, string $indent = "  ", string $eol = "\n")
    {
        $this->resolver = $resolver ?? $this;
        $this->indent = $indent;
        $this->eol = $eol;
    }

    public function indent()
    {
        return $this->indent;
    }

    public function eol()
    {
        return $this->eol;
    }

    public function export($data, $level = 0): string
    {
        $resolved = $this->resolver->resolve($data);
        if ($resolved instanceof ExportableInterface) {
            return $resolved->exportable($this, $level);
        }
        return var_export($resolved, true);
    }

    public function resolve($data)
    {
        if ($data instanceof ExportableInterface) {
            return $data;
        }
        if (is_iterable($data)) {
            return new ExportableIterable($data);
        }
        if ($data instanceof Closure) {
            return new ExportableClosure($data);
        }
        return $data;
    }
}
