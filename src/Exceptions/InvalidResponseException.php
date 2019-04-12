<?php

namespace Zarinpal\Exceptions;

use InvalidArgumentException;
use Throwable;

class InvalidResponseException extends InvalidArgumentException
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
