<?php

namespace Fas\Exportable;

class ExportableIterable implements ExportableInterface
{
    private iterable $data;
    private string $indent = "  ";
    private string $eol = "\n";

    public function __construct(iterable $data)
    {
        $this->data = $data;
    }

    public function exportable(Exporter $exporter, $level = 0): string
    {
        $indent = str_repeat($this->indent, $level);
        $result = "";
        $items = [];
        foreach ($this->data as $key => $value) {
            if (!is_scalar($key)) {
                throw new InvalidKeyException($key);
            }
            $eKey = var_export($key, true);
            $eValue = $exporter->export($value, $level + 1);
            $items[] =  $indent . $this->indent . $eKey . ' => ' . $eValue;
        }
        $result = '[' . $this->eol . implode(',' . $this->eol, $items) . $this->eol . $indent . ']';
        return $result;
    }
}
