<?php

namespace App\Service\Matrix\Exception;

use RuntimeException;
use Throwable;

class CharacteristicAlreadyExistsException extends RuntimeException
{
    public function __construct(
        $message = 'Показатель уже существует',
        $code = 0,
        Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
