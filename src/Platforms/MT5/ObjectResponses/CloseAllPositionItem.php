<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

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