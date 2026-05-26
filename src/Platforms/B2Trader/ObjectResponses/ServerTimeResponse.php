<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\ObjectResponses;

final class ServerTimeResponse
{
    public function __construct(
        public readonly string $server_time,
    ) {}
}
