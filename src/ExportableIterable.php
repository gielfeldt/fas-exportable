<?php

namespace Fas\Exportable;

class ExportableIterable implements ExportableInterface
{
    private iterable $data;

    public function __construct(iterable $data)
    {
        $this->data = $data;
    }

    public function exportable(Exporter $exporter, $level = 0): string
    {
        $indent = str_repeat($exporter->indent(), $level);
        $eol = $exporter->eol();
        $result = "";
        $items = [];
        foreach ($this->data as $key => $value) {
            if (!is_scalar($key)) {
                throw new InvalidKeyException($key);
            }
            $eKey = var_export($key, true);
            $eValue = $exporter->export($value, $level + 1);
            $items[] =  $indent . $exporter->indent() . $eKey . ' => ' . $eValue;
        }
        $result = "[$eol" . implode(",$eol", $items) . $eol . $indent . "]";
        return $result;
    }
}
