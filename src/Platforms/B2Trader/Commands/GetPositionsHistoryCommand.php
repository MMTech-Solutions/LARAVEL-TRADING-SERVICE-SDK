<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class GetPositionsHistoryCommand implements CommandInterface
{
    public function __construct(
        public readonly int $limit,
        public readonly string $created_from,
        public readonly string $created_to,
        public readonly string $last_id,
    ){}

    public function toArray(): array
    {
        return [
            'limit' => $this->limit,
            'created_from' => $this->created_from,
            'created_to' => $this->created_to,
            'last_id' => $this->last_id,
        ];
    }
}