<?php

namespace Maize\Processor;

use XSLTProcessor;

class Processor
{
    private XSLTProcessor $processor;

    private ?Stylesheet $stylesheet;

    public function __construct(
        private Document $document,
        // private bool $debug = false
    ) {
        $this
            ->withProcessor()
            ->withStylesheet(
                $this->document->getStylesheet()
            );
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

    public function withStylesheet(Stylesheet|string $stylesheet): self
    {
        if (is_string($stylesheet)) {
            $stylesheet = Stylesheet::fromFilename($stylesheet);
        }

        $this->stylesheet = $stylesheet;

        return $this;
    }

    public function execute(): string|null|false
    {
        return $this
            // ->debug()
            ->importStylesheet()
            ->process();
    }

    protected function importStylesheet(): self
    {
        $this->processor->importStylesheet(
            $this->stylesheet->get()
        );

        return $this;
    }

    protected function process(): string|null|false
    {
        return $this->processor->transformToXML(
            $this->document->get()
        );
    }

    private function withProcessor(): self
    {
        $this->processor = new XSLTProcessor();

        return $this;
    }

    // protected function debug(): self
    // {
    //     if ($this->debug) {
    //     $errors = libxml_get_errors();
    //     libxml_use_internal_errors(false);
    //     }

    //     return $this;
    // }
}
