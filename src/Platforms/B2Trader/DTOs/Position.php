<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs;

class Position
{
    public function __construct(
        public readonly string $position_id,
        public readonly string $login,
        public readonly string $user_id,
        public readonly int $public_account_id,
        public readonly string $symbol_id,
        public readonly string $action,
        public readonly float $volume,
        public readonly string $created_at,
        public readonly string $updated_at,
        public readonly float $unrealized_pnl,
        public readonly float $realized_pnl,
        public readonly float $commission,
        public readonly float $open_price,
        public readonly string $comment
    ) {}
}
