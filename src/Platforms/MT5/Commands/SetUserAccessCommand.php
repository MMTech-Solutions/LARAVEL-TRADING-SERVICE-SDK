<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class SetUserAccessCommand implements CommandInterface
{
    public function __construct(
        public string $login,
        public string $access,
    ) {}

    public function toArray(): array
    {
        return [
            'login' => $this->login,
            'access' => $this->access,
        ];
    }
}
