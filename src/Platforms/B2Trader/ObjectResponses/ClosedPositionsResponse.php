<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\ObjectResponses;

use Mmt\TradingServiceSdk\WireHydration\Attributes\WireMapped;

#[WireMapped]
class ClosedPositionsResponse
{
    public function __construct(
        public string $login,
        public string $user_id,
        public string $from,
        public string $to,
        public string $closed_from,
        public string $closed_to,
        public int $count,
        /** @var \Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs\ClosedPosition[] */
        public array $positions,
    ) {}
}
