<?php

declare(strict_types=1);

namespace Mmt\TradingServiceSdk\Platforms\CTrader\DTOs;

/**
 * Represents a CTrader account group with its settings.
 */
final readonly class GroupData
{
    public function __construct(
        public ?string $name = null,
        public ?bool $enabled = null,
        public ?string $currency = null,
        public ?float $margin_call = null,
        public ?string $symbols_group = null,
        public ?string $id = null,
    ) {}
}
