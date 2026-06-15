<?php

declare(strict_types=1);

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs;

/**
 * B2Trader backoffice account status row (status-info / accounts access endpoint).
 */
final class AccountAccessData
{
    public function __construct(
        public readonly string $account_id,
        public readonly string $status,
        public readonly int $open_positions_count = 0,
        public readonly int $open_orders_count = 0,
    ) {}
}
