<?php

namespace App\Service\Matrix\Exception;

use RuntimeException;
use Throwable;

class AlternativeAlreadyExistsException extends RuntimeException
{
    public function __construct(
        $message = 'Альтернатива уже существует',
        $code = 0,
        Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
