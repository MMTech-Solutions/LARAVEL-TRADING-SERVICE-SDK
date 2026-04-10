<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

class SymbolItem
{
    public function __construct(
        public readonly string $name,
        public readonly string $path,
        public readonly int $volume_min,
        public readonly int $contract_size,
        public readonly int $volume_step,
        public readonly int $digits,
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
        );
    }
}