<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

final class OpenPositionItem
{
    public function __construct(
        /** Order ticket id returned by the bridge. */
        public readonly string $order_id,
    ) {}
}
