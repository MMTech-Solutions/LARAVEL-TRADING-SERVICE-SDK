<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs;

final class TransactionHistoryItem
{
    public function __construct(
        /** Transfer ID */
        public readonly string $id,
        /** Owner user ID */
        public readonly string $user_id,
        /** Trading account login (B2T account id) */
        public readonly string $login,
        /** Transfer type (deposit, withdrawal, etc.) */
        public readonly string $type,
        /** Transfer amount */
        public readonly float $amount,
        /** Current status of the transfer */
        public readonly string $status,
        /** Creation timestamp in milliseconds since epoch */
        public readonly int $created_at,
        /** Last update timestamp in milliseconds since epoch */
        public readonly int $updated_at,
    ) {}
}
