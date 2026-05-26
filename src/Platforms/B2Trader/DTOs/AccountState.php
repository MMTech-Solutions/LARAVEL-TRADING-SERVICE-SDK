<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs;

final class AccountState
{
    public function __construct(
        public readonly string $login,
        public readonly string $access,
    ) {}
}
