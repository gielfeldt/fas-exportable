<?php

namespace Fas\Exportable;

use Closure;
use Fas\Exportable\ExportableInterface;

class Exporter implements ResolverInterface
{
    private array $attributes = [];

    public function __construct(?ResolverInterface $resolver = null)
    {
        $this->resolver = $resolver ?? $this;
    }

    public function export($data, $level = 0): string
    {
        $resolved = $this->resolver->resolve($data);
        if ($resolved instanceof ExportableInterface) {
            return $resolved->exportable($this, $level);
        }
        return var_export($resolved, true);
    }

    public function hasAttribute(string $key)
    {
        return array_key_exists($key, $this->attributes);
    }

    public function getAttribute(string $key, $default = null)
    {
        return $this->attributes[$key] ?? $default;
    }

    public function setAttribute(string $key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function removeAttribute(string $key)
    {
        unset($this->attributes[$key]);
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
