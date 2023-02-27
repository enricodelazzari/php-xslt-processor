<?php

use Maize\Processor\Processor;

it('can test', function () {

    $data = Processor::fromFilename(__DIR__ . '/Support/XML/1/document.xml')
        ->withStylesheet()
        ->execute();

    dd($data);


    expect(true)->toBeTrue();
});
