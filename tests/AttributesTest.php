<?php

namespace Fas\Exportable\Tests;

use Fas\Exportable\ExportableInterface;
use Fas\Exportable\Exporter;
use PHPUnit\Framework\TestCase;

class AttributesTest extends TestCase
{

    public function testCanSetAttributes()
    {
        $exporter = new Exporter();
        $exporter->setAttribute('my-key', 'my-value');

        $exportable = new class implements ExportableInterface {
            public function exportable(Exporter $exporter, $level = 0): string
            {
                $verify = $exporter->hasAttribute('my-key') ? 'has' : '';
                $verify .= $exporter->getAttribute('my-key') ?? '';
                $verify .= $exporter->getAttribute('my-non-key', 'my-non-value') ?? '';
                $exporter->removeAttribute('my-key');
                $verify .= $exporter->hasAttribute('my-key') ? '' : 'removed';
                return $verify;
            }
        };
        $exported = $exporter->export($exportable);

        $this->assertEquals('hasmy-valuemy-non-valueremoved', $exported);
    }
}
