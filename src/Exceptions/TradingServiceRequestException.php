<?php

namespace Mmt\TradingServiceSdk\Exceptions;

use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

final class TradingServiceRequestException extends RuntimeException
{
    public static function fromGuzzle(GuzzleException $e): self
    {
        return new self(
            message:  'TradingService HTTP request failed: ' . $e->getMessage(),
            code:     $e->getCode(),
            previous: $e,
        );
    }
}
