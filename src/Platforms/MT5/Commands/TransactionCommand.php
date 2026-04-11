<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Mmt\TradingServiceSdk\Platforms\MT5\Enums\TransactionTypeEnum;

/** Body for POST /transactions/change and /transactions/set. */
class TransactionCommand implements CommandInterface
{
    public function __construct(
        public string $login,
        public float $amount,
        public TransactionTypeEnum $type = TransactionTypeEnum::BALANCE,
        public ?string $comment = null,
    ) {}

    public function toArray(): array
    {
        $payload = [
            'login' => $this->login,
            'amount' => $this->amount,
            'type' => $this->type->name,
            'comment' => $this->comment,
        ];

        return array_filter($payload, fn ($v) => !is_null($v));
    }
}
