<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\ObjectResponses;

use Mmt\TradingServiceSdk\WireHydration\Attributes\WireMapped;

#[WireMapped]
final class AccountsByLoginResponse
{
    public function __construct(
        /** @var \Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs\Account[] */
        public readonly array $accounts,
        /** @var string[] */
        public readonly array $missing_logins,
    ) {}
}
