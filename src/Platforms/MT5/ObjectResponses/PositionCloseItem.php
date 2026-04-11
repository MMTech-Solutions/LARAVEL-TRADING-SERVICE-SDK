<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

final class PositionCloseItem
{
    public function __construct(
        /** Close order ticket id. */
        public string $order_id,
        /** Close price. */
        public float $price = 0,
        /** Closed volume in lots. */
        public float $volume = 0,
        /** Deal ticket id. */
        public string $deal_id,
        /** Position ticket id that was closed. */
        public string $position_id,
    ) {}
}