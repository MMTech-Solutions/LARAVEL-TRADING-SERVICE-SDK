<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs;

class DealInfo
{
    public function __construct(
        public string $id,
        public string $login,
        public string $order_id,
        public string $position_id,
        public string $symbol,
        public float $volume,
        public float $price,
        public float $profit,
        public string $time,
        public string $type,
        public string $entry,
    ) {}
}
