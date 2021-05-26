<?php

namespace Fas\Exportable;

use Exception;
use Throwable;

class InvalidKeyException extends Exception
{
    public function __construct($key, ?Throwable $previous = null)
    {
        $serialized = serialize($key);
        parent::__construct("Cannot use '$serialized' as key", 0, $previous);
    }
}
