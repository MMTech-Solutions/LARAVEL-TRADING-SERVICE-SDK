<?php

declare(strict_types=1);

namespace Mmt\TradingServiceSdk\Platforms\CTrader\DTOs;

/**
 * Represents a tradable symbol (instrument) in CTrader.
 */
final readonly class SymbolData
{
    public function __construct(
        public ?string $name = null,
        public ?string $path = null,
        public ?string $description = null,
        public ?float $volume_min = null,
        public ?float $contract_size = null,
        public ?float $volume_step = null,
        public ?int $digits = null,
    ) {}
}
