<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs;

use Mmt\TradingServiceSdk\WireHydration\Attributes\WireMapped;

#[WireMapped]
final class AccountState
{
    public function __construct(
        public readonly string $login,
        public readonly string $access,
    ) {}
}
