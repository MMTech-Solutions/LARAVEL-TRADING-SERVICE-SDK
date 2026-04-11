<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class ChangePasswordCommand implements CommandInterface
{
    public function __construct(
        public string $login,
        public string $new_password,
        public bool $is_investor = false,
    ) {}

    public function toArray(): array
    {
        return [
            'login' => $this->login,
            'new_password' => $this->new_password,
            'is_investor' => $this->is_investor,
        ];
    }
}
