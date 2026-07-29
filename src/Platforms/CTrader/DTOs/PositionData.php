<?php

declare(strict_types=1);

namespace Mmt\TradingServiceSdk\Platforms\CTrader\DTOs;

/**
 * Represents an open trading position in CTrader.
 */
final readonly class PositionData
{
    public function __construct(
        public ?string $id = null,
        public ?string $login = null,
        public ?string $symbol = null,
        public ?float $volume = null,
        public ?float $open_price = null,
        public ?float $current_price = null,
        public ?float $sl = null,
        public ?float $tp = null,
        public ?float $swap = null,
        public ?float $profit = null,
        public ?string $comment = null,
        public ?string $time = null,
    ) {}
}
