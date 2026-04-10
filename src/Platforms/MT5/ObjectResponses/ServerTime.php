<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

class ServerTime
{
    public function __construct(
        public readonly string $server_time,
    ) {}
}