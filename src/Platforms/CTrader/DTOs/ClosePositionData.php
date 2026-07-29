<?php

declare(strict_types=1);

namespace Mmt\TradingServiceSdk\Platforms\CTrader\DTOs;

/**
 * Represents the result returned when a specific position is closed in CTrader.
 */
final readonly class ClosePositionData
{
    public function __construct(
        public ?string $order_id = null,
        public ?float $price = null,
        public ?float $volume = null,
        public ?string $deal_id = null,
        public ?string $position_id = null,
    ) {}
}
