<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

/**
 * Body for POST /trading/close-all.
 *
 * Closes all open positions and cancels all open orders for the given login in parallel on the server.
 */
class CloseAllTradingCommand implements CommandInterface
{
    public function __construct(
        public string $login,
        public ?string $symbol_filter = null,
    ) {}

    public function toArray(): array
    {
        $payload = [
            'login' => $this->login,
            'symbol_filter' => $this->symbol_filter,
        ];

        return array_filter($payload, fn ($v) => ! is_null($v));
    }
}
