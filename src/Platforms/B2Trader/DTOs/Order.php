<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs;

class Order
{
    public function __construct(
        public readonly string $id,
        public readonly string $login,
        public readonly string $symbol,
        public readonly string $volume,
        public readonly string $price,
        public readonly string $time,
        public readonly string $type,
        public readonly string $state,
    ) {}
}
