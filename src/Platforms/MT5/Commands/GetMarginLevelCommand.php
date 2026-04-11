<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class GetMarginLevelCommand implements CommandInterface
{
    public function __construct(
        public string $login,
    ) {}

    public function toArray(): array
    {
        return [];
    }
}
