<?php

namespace Fas\Exportable;

interface ExportableInterface
{
    public function exportable(Exporter $exporter, $level = 0): string;
}
