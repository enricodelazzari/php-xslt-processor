<?php

namespace Maize\Processor\Exceptions;

use Exception;

class InvalidStylesheetException extends Exception
{
    public static function make()
    {
        return new self('The given stylesheet must be a valid file.');
    }
}
