<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs;

use Mmt\TradingServiceSdk\WireHydration\Attributes\WireMapped;

#[WireMapped]
class GroupInfo
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $connector_account,
        public readonly bool $is_default,
        public readonly int $accounts_count,
    ) {}
}
