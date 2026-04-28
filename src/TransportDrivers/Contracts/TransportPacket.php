<?php

namespace Mmt\TradingServiceSdk\TransportDrivers\Contracts;

class TransportPacket
{
    public function __construct(
        public readonly string $endpoint,
        public readonly array $payload,
        public readonly array $metadata = [],
    ) {}
}
