<?php

declare(strict_types=1);

namespace Mmt\TradingServiceSdk\Platforms\CTrader\DTOs;

/**
 * Represents the result of a balance transaction in CTrader.
 */
final readonly class TransactionData
{
    public function __construct(
        public ?string $ticket = null,
        public ?float $new_balance = null,
    ) {}
}
