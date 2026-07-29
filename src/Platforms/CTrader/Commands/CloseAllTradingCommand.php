<?php

namespace Mmt\TradingServiceSdk\Platforms\CTrader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Override;

/**
 * Command to close all trading activity (positions and orders) for a CTrader account.
 *
 * Sends a POST request to /v1/ctrader/connections/{connection_id}/trading/close-all.
 */
class CloseAllTradingCommand implements CommandInterface
{
    public function __construct(
        // Required fields
        public readonly string $login,

        // Optional fields
        public readonly ?string $symbol_filter = null,
        public readonly ?string $comment = null,
    ) {}

    /**
     * Serialize the command to an associative array.
     * Required fields are always included; null optionals are stripped.
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(): array
    {
        $data = [
            'login' => $this->login,
        ];

        if ($this->symbol_filter !== null) {
            $data['symbol_filter'] = $this->symbol_filter;
        }

        if ($this->comment !== null) {
            $data['comment'] = $this->comment;
        }

        return $data;
    }
}
