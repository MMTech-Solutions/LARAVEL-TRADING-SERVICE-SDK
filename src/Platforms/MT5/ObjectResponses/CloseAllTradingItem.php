<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

use Mmt\TradingServiceSdk\WireHydration\Attributes\WireMapped;

/**
 * Response for POST /trading/close-all.
 *
 * Contains closed positions and cancelled order ticket ids.
 */
#[WireMapped]
final class CloseAllTradingItem
{
    public function __construct(
        /** @var CloseAllPositionItem[] Closed positions. */
        public array $positions,
        /** @var string[] Cancelled open order ticket ids. */
        public array $order_ids,
    ) {}
}
