<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class CheckPasswordCommand implements CommandInterface
{
    public function __construct(
        public string $login,
        public string $password,
    ) {}

    public function toArray(): array
    {
        return [
            'login' => $this->login,
            'password' => $this->password,
        ];
    }
}
