<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

use Mmt\TradingServiceSdk\WireHydration\Attributes\WireMapped;

#[WireMapped]
final class CloseAllPositionItem
{
    public function __construct(
        /** Close order ticket id. */
        public string $position_id,
        /** Close price. */
        public string $order_id,
        /** Closed volume in lots. */
        public string $deal_id,
    ) {}
}
