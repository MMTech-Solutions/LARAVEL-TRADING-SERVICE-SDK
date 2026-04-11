<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

final class DealItem
{
    public function __construct(
        /** Deal ticket id. */
        public string $id,
        /** Account login (deal owner). */
        public string $login,
        /** Related order id. */
        public string $order_id,
        /** Related position id. */
        public string $position_id,
        /** Symbol (e.g. EURUSD). */
        public string $symbol,
        /** Volume in lots. */
        public float $volume = 0,
        /** Deal price. */
        public float $price = 0,
        /** Profit/loss. */
        public float $profit = 0,
        /** Deal time (Unix timestamp). */
        public int $time = 0,
        /** Deal type. */
        public string $type,
        /** Entry (in/out). */
        public string $entry,
    ) {}
}