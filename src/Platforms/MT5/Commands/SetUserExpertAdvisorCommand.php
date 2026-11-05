<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class SetUserExpertAdvisorCommand implements CommandInterface
{
    public function __construct(
        public string $login,
        public bool $enabled,
    ) {}

    public function toArray(): array
    {
        return [
            'login' => $this->login,
            'enabled' => $this->enabled,
        ];
    }
}
