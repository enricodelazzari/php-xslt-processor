<?php

namespace Maize\Processor;

use DOMDocument;
use XSLTProcessor;

class Processor
{
    public function __construct(
        private Document $document,
        private ?XSLTProcessor $processor = null,
        private ?DOMDocument $stylesheet = null,
        // private bool $debug = false
    ) {
        $this->processor ??= new XSLTProcessor();
        $this->stylesheet = $this->document->getStylesheet()->get();
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

    // public function withDebug(bool $debug = true): self
    // {
    //     $this->debug = $debug;

    //     return $this;
    // }

    public function withStylesheet(DOMDocument $xsl): self
    {
        $this->stylesheet = $xsl;

        return $this;
    }

    public function execute(): string|null|false
    {
        return $this
            ->debug()
            ->importStylesheet()
            ->process();
    }

    protected function importStylesheet(): self
    {
        $this->processor->importStylesheet(
            $this->stylesheet
        );

        return $this;
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
