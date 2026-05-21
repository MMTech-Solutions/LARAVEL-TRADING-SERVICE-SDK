<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

/** Body for POST /orders/cancel-all. Does not close positions. */
class CancelAllOpenOrdersCommand implements CommandInterface
{
    public function __construct(
        public string $login,
    ) {}

    public function toArray(): array
    {
        return [
            'login' => $this->login,
        ];
    }
}
