<?php

namespace Maize\Processor;

use DOMDocument;

class Stylesheet
{
    public function __construct(
        private string $filename,
        private DOMDocument $stylesheet
    ) {
    }

    public static function fromDocument(Document $document): self
    {
        return static::fromFilename(
            $document->getStylesheetFilename()
        );
    }

    public static function fromFilename(string $filename): self
    {
        return new self(
            $filename,
            (new DOMDocument())->load($filename)
        );
    }

    public function get(): DOMDocument
    {
        return $this->stylesheet;
    }
}
