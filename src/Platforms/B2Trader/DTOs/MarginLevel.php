<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs;

final class MarginLevel
{
    public function __construct(
        public readonly string $user_id,
        public readonly string $login,
        public readonly string $public_account_id,
        public readonly string $margin_level,
        public readonly string $equity,
        public readonly string $balance,
        public readonly string $used_margin,
        public readonly string $free_margin,
        public readonly string $profit,
    ) {}
}
