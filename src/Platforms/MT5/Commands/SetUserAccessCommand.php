<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Mmt\TradingServiceSdk\Platforms\MT5\Enums\AccessLevelEnum;

class SetUserAccessCommand implements CommandInterface
{
    public function __construct(
        public string $login,
        public AccessLevelEnum $access,
    ) {}

    public function toArray(): array
    {
        return [
            'login' => $this->login,
            'access' => $this->access->labelToLowerString(),
        ];
    }
}
