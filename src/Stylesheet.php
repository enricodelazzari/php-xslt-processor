<?php

namespace Maize\Processor;

use DOMDocument;

class Stylesheet
{
    public function __construct(
        // private string $filename,
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
        $document = new DOMDocument();
        $document->load($filename);

        return new self(/*$filename,*/ $document);
    }

    public function get(): DOMDocument
    {
        return $this->stylesheet;
    }
}
