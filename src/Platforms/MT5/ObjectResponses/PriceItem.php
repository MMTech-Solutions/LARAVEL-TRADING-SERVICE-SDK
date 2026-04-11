<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

final class PriceItem
{
    public function __construct(
        public string $symbol,
        public MarketPriceItem $price
    ) {}
}