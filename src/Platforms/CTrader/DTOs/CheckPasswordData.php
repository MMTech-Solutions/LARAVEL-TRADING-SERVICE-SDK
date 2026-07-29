<?php

declare(strict_types=1);

namespace Mmt\TradingServiceSdk\Platforms\CTrader\DTOs;

/**
 * Represents the result of a password verification request in CTrader.
 */
final readonly class CheckPasswordData
{
    public function __construct(
        public ?bool $password_correct = null,
    ) {}
}
