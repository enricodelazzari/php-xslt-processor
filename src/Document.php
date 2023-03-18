<?php

namespace Maize\Processor;

use DOMDocument;
use DOMXPath;
use Maize\Processor\Exceptions\InvalidStylesheetException;
use Maize\Processor\Support\Str;

class Document
{
    public function __construct(
        private string $filename,
        private DOMDocument $document
    ) {
    }

    public static function fromFilename(string $filename): self
    {
        $document = new DOMDocument();
        $document->load($filename);

        return new self($filename, $document);
    }

    public function getStylesheetFilename(): string
    {
        $xslHref = (new DOMXPath($this->document))->evaluate(
            'string(//processing-instruction()[name() = "xml-stylesheet"])'
        );
        $xslHref = Str::match('/href=[\'"]([^\'"]+)[\'"]/i', $xslHref);

        $xslPath = dirname(realpath($this->filename))."/$xslHref";

        if (! is_file($xslPath)) {
            throw InvalidStylesheetException::make();
        }

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
