<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\ObjectResponses;

use Mmt\TradingServiceSdk\Platforms\B2Trader\Enums\TransactionTypeEnum;

class AddBalanceResponse
{
    public function __construct(
        public readonly string $account_id,
        public readonly string $user_id,
        public readonly string $identifier,
        public readonly TransactionTypeEnum $operation,
        public readonly array $transfer,
        public readonly bool $confirmed,
        public readonly ?string $note = null,
    ) {}
}
