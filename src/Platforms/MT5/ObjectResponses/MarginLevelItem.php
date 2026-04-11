<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

class MarginLevelItem
{
    public function __construct(
        public string $login,
        public float $balance = 0.0,
        public float $credit = 0.0,
        public float $equity = 0.0,
        public float $margin = 0.0,
        public float $margin_free = 0.0,
        public float $margin_level = 0.0,
        public int $leverage = 0,
    ) {}
}
