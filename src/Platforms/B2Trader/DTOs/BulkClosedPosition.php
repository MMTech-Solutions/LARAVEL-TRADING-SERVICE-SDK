<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs;

class BulkClosedPosition
{
    public function __construct(
        public readonly string $position_id,
        public readonly string $order_id,
        public readonly string $deal_id,
    ) {}
}
