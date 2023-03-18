<?php

use Maize\Processor\Exceptions\InvalidStylesheetException;
use Maize\Processor\Processor;

it('can process xml with default stylesheet', function ($document, $result) {
    $data = Processor::fromFilename(__DIR__.$document)->execute();

    $this->assertXmlStringEqualsXmlFile(__DIR__.$result, $data);
})->with([
    ['document' => '/Support/XML/1/document.xml', 'result' => '/Support/XML/1/result.xml'],
    ['document' => '/Support/XML/2/document.xml', 'result' => '/Support/XML/2/result.xml'],
]);

it('can process xml with stylesheet override', function ($document, $stylesheet, $result) {
    $data = Processor::fromFilename(__DIR__.$document)
        ->withStylesheet(__DIR__.$stylesheet)
        ->execute();

    $this->assertXmlStringEqualsXmlFile(__DIR__.$result, $data);
})->with([
    ['document' => '/Support/XML/1/document.xml', 'stylesheet' => '/Support/XML/1/stylesheet.xsl', 'result' => '/Support/XML/1/result.xml'],
    ['document' => '/Support/XML/2/document.xml', 'stylesheet' => '/Support/XML/2/styles/stylesheet.xsl', 'result' => '/Support/XML/2/result.xml'],
]);

it('can fail without stylesheet', function ($document) {
    Processor::fromFilename(__DIR__.$document)->execute();
})->throws(InvalidStylesheetException::class)->with([
    ['document' => '/Support/XML/4/document.xml'],
]);

it('can fail with invalid stylesheet', function ($document) {
    Processor::fromFilename(__DIR__.$document)->execute();
})->throws(InvalidStylesheetException::class)->with([
    ['document' => '/Support/XML/5/document.xml'],
]);

it('can fail with invalid stylesheet override', function ($document, $stylesheet) {
    Processor::fromFilename(__DIR__.$document)
        ->withStylesheet($stylesheet)
        ->execute();
})->throws(InvalidStylesheetException::class)->with([
    ['document' => '/Support/XML/5/document.xml', 'stylesheet' => __DIR__.'/Support/XML/5/'],
]);
