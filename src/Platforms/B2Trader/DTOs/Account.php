<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs;

use Mmt\TradingServiceSdk\WireHydration\Attributes\WireMapped;

#[WireMapped]
final class Account
{
    public function __construct(
        public readonly string $login,
        public readonly string $user_id,
        public readonly string $group_id,
        public readonly string $name,
        public readonly string $type,
        public readonly string $balance,
        public readonly float $equity,
        public readonly string $currency,
    ) {}
}
