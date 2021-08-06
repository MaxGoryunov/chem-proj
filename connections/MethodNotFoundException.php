<?php

namespace Connections;

use Exception;
use Throwable;

final class MethodNotFoundException extends Exception
{

    /**
     * Ctor.
     *
     * @param string         $message error message.
     * @param int            $code    error code.
     * @param Throwable|null $cause   error cause/origin.
     */
    public function __construct(
        string $message,
        int $code = 0,
        ?Throwable $cause = null
    ) {
        parent::__construct($message, $code, $cause);
    }
}
