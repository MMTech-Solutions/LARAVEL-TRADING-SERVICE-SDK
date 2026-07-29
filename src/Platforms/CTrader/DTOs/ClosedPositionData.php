<?php

declare(strict_types=1);

namespace Mmt\TradingServiceSdk\Platforms\CTrader\DTOs;

/**
 * Represents the identifiers returned when a position is closed in CTrader.
 */
final readonly class ClosedPositionData
{
    public function __construct(
        public ?string $position_id = null,
        public ?string $order_id = null,
        public ?string $deal_id = null,
    ) {}
}
