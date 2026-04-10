<?php

namespace Mmt\TradingServiceSdk\Platforms\Shared\ObjectResponses;

class BrokerConnectionResponse
{
    public function __construct(
        public readonly string $connection_id,
        public readonly string $broker_key
    ) {}
}