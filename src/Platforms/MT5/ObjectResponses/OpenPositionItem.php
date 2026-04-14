<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

final class OpenPositionItem
{
    public function __construct(
        public readonly string $order_id,
    ){}
}