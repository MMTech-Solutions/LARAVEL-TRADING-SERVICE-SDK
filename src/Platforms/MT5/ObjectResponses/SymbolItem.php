<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

use Mmt\TradingServiceSdk\WireHydration\Attributes\WireMapped;

#[WireMapped]
class SymbolItem
{
    public function __construct(
        public readonly string $name,
        public readonly string $path,
        /** Minimum volume in lots (float to support fractional lot sizes). */
        public readonly float $volume_min,
        public readonly float $contract_size,
        /** Volume step in lots. */
        public readonly float $volume_step,
        public readonly int $digits,
        public readonly string $description = '',
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            path: $data['path'],
            volume_min: $data['volume_min'],
            contract_size: $data['contract_size'],
            volume_step: $data['volume_step'],
            digits: $data['digits'],
            description: $data['description'] ?? '',
        );
    }
}
