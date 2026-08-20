<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs;

use Mmt\TradingServiceSdk\WireHydration\Attributes\WireMapped;

#[WireMapped]
class SymbolInfo
{
    public function __construct(
        public readonly string $name,
        public readonly string $path,
        public readonly string $description,
        public readonly float $volume_min,
        public readonly float $contract_size,
        public readonly float $volume_step,
        public readonly int $digits,
    ) {}
}
