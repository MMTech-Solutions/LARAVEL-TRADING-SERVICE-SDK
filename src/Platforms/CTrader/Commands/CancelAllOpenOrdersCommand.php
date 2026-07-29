<?php

namespace Mmt\TradingServiceSdk\Platforms\CTrader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Override;

/**
 * Command to cancel all open orders for a CTrader account.
 *
 * Sends a POST request to /v1/ctrader/connections/{connection_id}/orders/cancel-all.
 */
class CancelAllOpenOrdersCommand implements CommandInterface
{
    public function __construct(
        // Required fields
        public readonly string $login,
    ) {}

    /**
     * Serialize the command to an associative array.
     * Returns only the login field.
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(): array
    {
        return [
            'login' => $this->login,
        ];
    }
}
