<?php

namespace Fas\Exportable;

class ExportableRaw implements ExportableInterface
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function exportable(Exporter $exporter, $level = 0): string
    {
        return $this->data;
    }
}
