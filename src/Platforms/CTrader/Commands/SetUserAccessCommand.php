<?php

namespace Mmt\TradingServiceSdk\Platforms\CTrader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Override;

/**
 * Command to set the access rights of a CTrader trading account.
 *
 * Sends a POST request to /v1/ctrader/connections/{connection_id}/users/access.
 */
class SetUserAccessCommand implements CommandInterface
{
    public function __construct(
        public readonly string $login,
        public readonly string $access,
    ) {}

    /**
     * Serialize the command to an associative array.
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(): array
    {
        return [
            'login'  => $this->login,
            'access' => $this->access,
        ];
    }
}
