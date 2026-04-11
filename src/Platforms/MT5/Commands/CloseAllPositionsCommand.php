<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class CloseAllPositionsCommand implements CommandInterface
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
