<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\ObjectResponses;

class OpenPositionResponse
{
    public function __construct(
        public readonly string $order_id,
        public readonly string $login,
        public readonly string $symbol,
        public readonly string $action,
        public readonly string $user_id,
        public readonly string $order_index,
    ){}
}