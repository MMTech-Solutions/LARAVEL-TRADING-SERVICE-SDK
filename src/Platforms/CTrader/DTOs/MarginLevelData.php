<?php

declare(strict_types=1);

namespace Mmt\TradingServiceSdk\Platforms\CTrader\DTOs;

/**
 * Represents margin and balance information for a CTrader account.
 */
final readonly class MarginLevelData
{
    public function __construct(
        public ?string $login = null,
        public ?float $balance = null,
        public ?float $credit = null,
        public ?float $equity = null,
        public ?float $margin = null,
        public ?float $margin_free = null,
        public ?float $margin_level = null,
        public ?int $leverage = null,
        public ?int $currency_digits = null,
    ) {}
}
