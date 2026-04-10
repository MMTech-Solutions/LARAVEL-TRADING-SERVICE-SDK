<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class GetSymbolCategoryCommand implements CommandInterface
{
    public function __construct(
        public string $connectionId
    ) {}

    public function toArray(): array
    {
        return [];
    }
}