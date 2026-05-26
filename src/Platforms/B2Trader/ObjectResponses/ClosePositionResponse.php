<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\ObjectResponses;

class ClosePositionResponse
{
    public function __construct(
        public readonly string $order_id,
        public readonly float $price,
        public readonly float $volume,
        public readonly string $deal_id,
        public readonly string $position_id
    ){}
}