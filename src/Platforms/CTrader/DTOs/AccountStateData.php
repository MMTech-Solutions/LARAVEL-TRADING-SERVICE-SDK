<?php

declare(strict_types=1);

namespace Mmt\TradingServiceSdk\Platforms\CTrader\DTOs;

/**
 * Represents the access state of a CTrader trading account.
 */
final readonly class AccountStateData
{
    public function __construct(
        public ?string $login = null,
        public ?string $access = null,
    ) {}
}
