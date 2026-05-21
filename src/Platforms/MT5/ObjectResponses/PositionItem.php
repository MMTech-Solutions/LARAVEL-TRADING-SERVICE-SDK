<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

class PositionItem
{
    public function __construct(
        /** Position ticket id. */
        public string $id,

        /** Account login (position owner). */
        public string $login,

        /** Symbol, e.g. "EURUSD". */
        public string $symbol,

        /** Volume in lots. */
        public float $volume = 0.0,

        /** Open price. */
        public float $open_price = 0.0,

        /** Current market price. */
        public float $current_price = 0.0,

        /** Stop loss (0 = none). */
        public float $sl = 0.0,

        /** Take profit (0 = none). */
        public float $tp = 0.0,

        /** Swap. */
        public float $swap = 0.0,

        /** Floating profit/loss. */
        public float $profit = 0.0,

        /** Position comment. */
        public string $comment = '',

        /** Open time (TimeCreate) as UTC ISO 8601, e.g. "2026-03-23T20:50:23Z". */
        public string $time = ''
    ) {}
}
