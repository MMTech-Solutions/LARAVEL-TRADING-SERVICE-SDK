<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\ObjectResponses;

use Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs\ClosedPosition;

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
        /** @var ClosedPosition[] */
        public array $positions,
    ) {}
}