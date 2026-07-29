<?php

declare(strict_types=1);

namespace Mmt\TradingServiceSdk\Platforms\CTrader\DTOs;

/**
 * Represents a pending or active order in CTrader.
 */
final readonly class OrderData
{
    public function __construct(
        public ?string $id = null,
        public ?string $login = null,
        public ?string $symbol = null,
        public ?float $volume = null,
        public ?float $price = null,
        public ?string $time = null,
        public ?string $type = null,
        public ?string $state = null,
    ) {}
}
