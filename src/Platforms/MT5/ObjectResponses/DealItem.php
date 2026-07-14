<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

use Mmt\TradingServiceSdk\WireHydration\Attributes\WireMapped;


#[WireMapped]
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
        public float $volume,
        /** Deal price. */
        public float $price,
        /** Profit/loss. */
        public float $profit,
        /** Deal time (Unix timestamp). */
        public int $time,
        /** Deal type. */
        public string $type,
        /** Entry (in/out). */
        public string $entry,
    ) {}
}
