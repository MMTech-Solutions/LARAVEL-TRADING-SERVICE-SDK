<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

use Mmt\TradingServiceSdk\WireHydration\Attributes\WireMapped;

#[WireMapped]
final class PriceHistoryItem
{
    public function __construct(
        public string $symbol,

        /** @var MarketPriceItem[] $points */
        public array $points
    ) {}
}
