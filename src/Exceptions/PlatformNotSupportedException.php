<?php

namespace Mmt\TradingServiceSdk\Exceptions;

use Exception;

class PlatformNotSupportedException extends Exception
{
    protected $message = 'Platform not supported';

    public function __construct(string $message = '', int $code = 500, ?\Throwable $previous = null)
    {
        parent::__construct(
            $message ?: $this->message,
            $code,
            $previous
        );
    }
}