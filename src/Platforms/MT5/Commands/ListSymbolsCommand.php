<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class ListSymbolsCommand implements CommandInterface
{
    public function __construct(
        public string $groupName
    ){}

    public function toArray(): array
    {
        return [
            'group_filter' => $this->groupName,
        ];
    }
}