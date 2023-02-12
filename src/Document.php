<?php

namespace Maize\Processor;

use DOMDocument;
use DOMXPath;

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
        $xslHref = $this->match('/href=[\'"]([^\'"]+)[\'"]/i', $xslHref);

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

    private static function match($pattern, $subject)
    {
        preg_match($pattern, $subject, $matches);

        if (! $matches) {
            return '';
        }

        return $matches[1] ?? $matches[0];
    }
}
