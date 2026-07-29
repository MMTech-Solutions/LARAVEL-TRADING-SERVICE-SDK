<?php

declare(strict_types=1);

namespace Mmt\TradingServiceSdk\Platforms\CTrader\DTOs;

/**
 * Represents a completed deal (execution) in CTrader.
 */
final readonly class DealData
{
    public function __construct(
        public ?string $id = null,
        public ?string $login = null,
        public ?string $order_id = null,
        public ?string $position_id = null,
        public ?string $symbol = null,
        public ?float $volume = null,
        public ?float $price = null,
        public ?float $profit = null,
        public ?string $time = null,
        public ?string $type = null,
        public ?string $entry = null,
    ) {}
}
