<?php

use Maize\Processor\Processor;

it('can test', function ($document, $result) {

    $data = Processor::fromFilename(__DIR__ . $document)->execute();

    $this->assertXmlStringEqualsXmlString(
        $data,
        file_get_contents(__DIR__ . $result)
    );

    // expect($data)->toEqual(
    //     file_get_contents(__DIR__ . $result)
    // );
})->with([
    ['document' => '/Support/XML/1/document.xml', 'result' => '/Support/XML/1/result.xml'],
    ['document' => '/Support/XML/2/document.xml', 'result' => '/Support/XML/2/result.xml'],
]);


/*it('can test1', function ($document, $result) {

    $data = Processor::fromFilename(__DIR__ . $document)->execute();

    expect($data)->toEqual(
        file_get_contents(__DIR__ . $result)
    );
})->with([
    ['document' => '/Support/XML/4/document.xml', 'result' => '/Support/XML/4/result.xml'],
]);
*/