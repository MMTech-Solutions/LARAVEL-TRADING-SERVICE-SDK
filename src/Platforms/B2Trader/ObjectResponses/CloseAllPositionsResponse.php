<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\ObjectResponses;

use Mmt\TradingServiceSdk\WireHydration\Attributes\WireMapped;

#[WireMapped]
final class CloseAllPositionsResponse
{
    public function __construct(
        /** @var \Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs\Position[] */
        public readonly array $positions,
        /** @var string[] */
        public readonly array $order_ids,
    ) {}
}
