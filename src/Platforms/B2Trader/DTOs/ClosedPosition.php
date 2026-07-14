<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs;

final class ClosedPosition
{
    public function __construct(
        public readonly string $position_id,
        public readonly string $login,
        public readonly string $symbol_id,
        public readonly string $action,
        public readonly string $volume_closed,
        public readonly string $open_price,
        public readonly string $close_price,
        public readonly string $realized_pnl,
        public readonly string $opened_at,
        public readonly string $closed_at,
        public readonly string $close_order_id,
        public readonly string $reason,
        public readonly string $comment,
    ) {}
}
