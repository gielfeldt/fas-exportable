<?php

namespace Fas\Exportable\Tests;

use ArrayObject;
use Fas\Exportable\ExportableInterface;
use Fas\Exportable\ExportableRaw;
use Fas\Exportable\Exporter;
use Fas\Exportable\InvalidKeyException;
use PHPUnit\Framework\TestCase;

class ExporterTest extends TestCase
{

    public function testCanExportClosure()
    {
        $exporter = new Exporter();

        $closure = function () {
            return "abc";
        };
        $exported = $exporter->export(['test' => $closure]);

        $imported = [];
        eval("\$imported = $exported;");

        $result = ($imported['test'])();

        $this->assertEquals("abc", $result);
    }

    public function testCanExportArray()
    {
        $exporter = new Exporter();

        $exported = $exporter->export([1, 2, 3]);
        $exported = preg_replace('/\s+/s', '', $exported);

        $this->assertEquals("[0=>1,1=>2,2=>3]", $exported);
    }

    public function testCanExportIterableObject()
    {
        $exporter = new Exporter();

        $exported = $exporter->export(new ArrayObject([1, 2, 3]));
        $exported = preg_replace('/\s+/s', '', $exported);

        $this->assertEquals("[0=>1,1=>2,2=>3]", $exported);
    }

    public function testCanExportRaw()
    {
        $exporter = new Exporter();

        $exported = $exporter->export([new ExportableRaw('test')]);
        $exported = preg_replace('/\s+/s', '', $exported);

        $this->assertEquals("[0=>test]", $exported);
    }

    public function testKeyMustBeScalar()
    {
        $exporter = new Exporter();

        $nonscalarKeys = function () {
            $key = ['is' => 'not scalar'];
            $value = 'is very scalar';
            yield $key => $value;
        };

        $this->expectException(InvalidKeyException::class);
        $exporter->export($nonscalarKeys());
    }
}
