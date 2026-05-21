<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

final class OpenPositionItem
{
    public function __construct(
        /** Order ticket id returned by the bridge. */
        public readonly string $order_id,
        /**
         * Position ticket id — some bridges return this instead of (or alongside) order_id.
         * Empty string when not provided.
         */
        public readonly string $position_id = '',
    ) {}
}