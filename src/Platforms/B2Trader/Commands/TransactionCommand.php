<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Mmt\TradingServiceSdk\Platforms\B2Trader\Enums\BalanceTypeEnum;

/**
 * Body for POST /transactions/change and /transactions/set.
 *
 * Cash balance: type=BALANCE (default). Credit grant/revoke: type=CREDIT with bucket="CREDIT".
 */
class TransactionCommand implements CommandInterface
{
    public function __construct(
        public readonly string $login,
        public readonly float $amount,
        public readonly string $asset_id,
        public readonly ?string $comment = null,
        public readonly BalanceTypeEnum $type = BalanceTypeEnum::BALANCE,
        public readonly ?string $bucket = null,
        public readonly ?string $idempotency_key = null,
    ) {}

    public function toArray(): array
    {
        $payload = [
            'login' => $this->login,
            'amount' => $this->amount,
            'asset_id' => $this->asset_id,
            'type' => $this->type->value,
            'comment' => $this->comment,
            'bucket' => $this->bucket,
            'idempotency_key' => $this->idempotency_key,
        ];

        return array_filter($payload, fn ($v) => ! is_null($v));
    }
}
