<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class TransactionCommand implements CommandInterface
{
    public function __construct(
        public readonly string $login,
        public readonly float $amount,
        public readonly string $asset_id,
        public readonly ?string $comment = null,
    ){}

    public function toArray(): array
    {
        return [
            'login' => $this->login,
            'amount' => $this->amount,
            'asset_id' => $this->asset_id,
            'comment' => $this->comment,
        ];
    }
}