<?php

declare(strict_types=1);

namespace Mmt\TradingServiceSdk\Platforms\CTrader\DTOs;

/**
 * Represents the current market price snapshot for a symbol in CTrader.
 */
final readonly class PriceData
{
    public function __construct(
        public ?string $symbol = null,
        public ?float $bid = null,
        public ?float $ask = null,
        public ?float $last = null,
        public ?int $timestamp = null,
    ) {}
}
