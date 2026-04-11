<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class GetMarginLevelsCommand implements CommandInterface
{
    /**
     * @param string[] $logins
     */
    public function __construct(
        public array $logins,
    ) {}

    public function toArray(): array
    {
        return [
            'logins' => $this->logins,
        ];
    }
}
