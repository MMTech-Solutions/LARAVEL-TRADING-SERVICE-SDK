<?php

namespace Mmt\TradingServiceSdk\Platforms\CTrader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Override;

/**
 * Command to retrieve closed positions for a CTrader account with optional filters.
 *
 * Sends a GET request to /v1/ctrader/connections/{connection_id}/positions/closed.
 * All fields are optional; null values are excluded from the serialized output.
 */
class GetClosedPositionsCommand implements CommandInterface
{
    public function __construct(
        // All fields are optional
        public readonly ?string $login = null,
        public readonly ?string $closed_from = null,
        public readonly ?string $closed_to = null,
    ) {}

    /**
     * Serialize the command to an associative array.
     * Null values are filtered out entirely.
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(): array
    {
        return array_filter(
            [
                'login'       => $this->login,
                'closed_from' => $this->closed_from,
                'closed_to'   => $this->closed_to,
            ],
            fn (mixed $value): bool => $value !== null,
        );
    }
}
