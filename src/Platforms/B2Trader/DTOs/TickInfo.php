<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs;

class TickInfo
{
    public function __construct(
        public readonly string $market_id,
        public readonly float $bid,
        public readonly float $ask,
        public readonly float $last,
        public readonly string $time,
        public readonly string $quote_source,
    ) {}
}
