<?php

namespace Models\Exceptions;

use Exception;
use Throwable;

/**
 * Exception for cases when given data is empty.
 */
final class EmptyDataException extends Exception
{

    /**
     * Ctor.
     *
     * @param string    $message error message.
     * @param int       $code    error code.
     * @param Throwable $cause   error cause.
     */
    public function __construct(
        string $message = "",
        int $code = 0,
        Throwable $cause = null
    ) {
        parent::__construct($message, $code, $cause);
    }
}
