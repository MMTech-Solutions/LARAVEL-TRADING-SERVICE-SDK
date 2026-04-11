<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class GetPriceHistoryCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public int $from_ts,
        public int $to_ts,
        public int $limit = 1000,
    ) {}

    public function toArray(): array
    {
        return [
            'from_ts' => $this->from_ts,
            'to_ts' => $this->to_ts,
            'limit' => $this->limit,
        ];
    }
}
