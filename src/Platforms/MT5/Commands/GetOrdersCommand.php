<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class GetOrdersCommand implements CommandInterface
{
    public function __construct(
        public string $login,
        public int $from_timestamp,
        public int $to_timestamp,
    ) {}

    public function toArray(): array
    {
        return [
            'login' => $this->login,
            'from_timestamp' => $this->from_timestamp,
            'to_timestamp' => $this->to_timestamp,
        ];
    }
}
