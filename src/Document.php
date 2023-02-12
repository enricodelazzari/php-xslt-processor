<?php

namespace Maize\Processor;

use DOMDocument;
use DOMXPath;
use Illuminate\Support\Str;

class Document
{
    public function __construct(
        private string $filename,
        private DOMDocument $document
    ) {
    }

    public static function fromFilename(string $filename): self
    {
        return new self(
            $filename,
            (new DOMDocument())->load($filename)
        );
    }

    public function getStylesheetFilename(): string
    {
        $xslHref = (new DOMXPath($this->document))->evaluate(
            'string(//processing-instruction()[name() = "xml-stylesheet"])'
        );
        $xslHref = Str::match('/href=[\'"]([^\'"]+)[\'"]/i', $xslHref);

        $xslPath = dirname(realpath($this->filename))."/$xslHref";

        // TODO: check if exists or is a folder
        // if (! $xslPath) {
        //     throw new Exception();
        // }

        return $xslPath;
    }

    public function getStylesheet(): Stylesheet
    {
        return Stylesheet::fromDocument($this);
    }

    public function get(): DOMDocument
    {
        return $this->document;
    }
}
