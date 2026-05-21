<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

/**
 * Response for POST /trading/close-all.
 *
 * Contains closed positions and cancelled order ticket ids.
 */
final class CloseAllTradingItem
{
    public function __construct(
        /** @var CloseAllPositionItem[] Closed positions. */
        public array $positions,
        /** @var string[] Cancelled open order ticket ids. */
        public array $order_ids,
    ) {}
}
