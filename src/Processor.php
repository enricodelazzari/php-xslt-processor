<?php

namespace Maize\Processor;

use DOMDocument;
use XSLTProcessor;

class Processor
{
    public function __construct(
        private Document $document,
        private XSLTProcessor $processor = new XSLTProcessor(),
        private bool $debug = false
    ) {
    }

    public static function fromFilename(string $filename): self
    {
        return static::fromDocument(
            Document::fromFilename($filename)
        );
    }

    public static function fromDocument(
        Document $document
    ): self {
        return new self($document);
    }

    public function withDebug(bool $debug = true): self
    {
        $this->debug = $debug;
    }

    public function withStylesheet(): self // DOMDocument $xsl = null
    {
        $this->processor->importStylesheet(
            $this->document->getStylesheet()->get()
        );

        return $this;
    }

    public function execute(): string|null|false
    {
        return $this
            ->debug()
            ->process();
    }

    protected function process(): string|null|false
    {
        return $this->processor->transformToXML(
            $this->document->get()
        );
    }

    protected function debug(): self
    {
        // if ($this->debug) {
        // $errors = libxml_get_errors();
        // libxml_use_internal_errors(false);
        // }

        return $this;
    }
}
