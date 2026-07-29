<?php

declare(strict_types=1);

namespace Mmt\TradingServiceSdk\Platforms\CTrader\DTOs;

/**
 * Represents the result of a position execution (open order) in CTrader.
 */
final readonly class ExecutePositionData
{
    public function __construct(
        public ?string $order_id = null,
        public ?string $login = null,
        public ?string $symbol = null,
        public ?string $action = null,
        public ?string $user_id = null,
        public ?string $order_index = null,
    ) {}
}
