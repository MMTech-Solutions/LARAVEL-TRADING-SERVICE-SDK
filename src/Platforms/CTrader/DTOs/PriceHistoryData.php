<?php

declare(strict_types=1);

namespace Mmt\TradingServiceSdk\Platforms\CTrader\DTOs;

/**
 * Represents historical price data (OHLCV points) for a symbol in CTrader.
 */
final readonly class PriceHistoryData
{
    public function __construct(
        public ?string $symbol = null,
        public mixed $points = null,
    ) {}
}
