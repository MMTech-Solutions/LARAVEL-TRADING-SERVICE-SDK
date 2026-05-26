<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

final class GetTransferHistoryCommand implements CommandInterface
{
    public function __construct(
        public string $limit,
        public int $offset,
        public int $status,
    ) {}
    
    public function toArray(): array
    {
        return [
            'limit' => $this->limit,
            'offset' => $this->offset,
            'status' => $this->status,
        ];
    }
}