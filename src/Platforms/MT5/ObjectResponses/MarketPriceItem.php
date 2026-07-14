<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

use Mmt\TradingServiceSdk\WireHydration\Attributes\WireMapped;

#[WireMapped]
final class MarketPriceItem
{
    public function __construct(
        public float $bid = 0,
        public float $ask = 0,
        public float $last = 0,
        public string $timestamp = ''
    ) {}
}
