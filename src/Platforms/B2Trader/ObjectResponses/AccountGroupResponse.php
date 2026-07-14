<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\ObjectResponses;

use Mmt\TradingServiceSdk\WireHydration\Attributes\WireMapped;

#[WireMapped]
final class AccountGroupResponse
{
    public function __construct(
        public readonly string $user_id,
        /** @var \Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs\Account[] */
        public readonly array $accounts,
    ) {}
}
