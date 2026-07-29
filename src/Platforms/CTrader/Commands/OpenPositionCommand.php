<?php

namespace Mmt\TradingServiceSdk\Platforms\CTrader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Override;

/**
 * Command to open a trading position on a CTrader account.
 *
 * Sends a POST request to /v1/ctrader/connections/{connection_id}/positions/execute.
 */
class OpenPositionCommand implements CommandInterface
{
    public function __construct(
        // Required fields
        public readonly string $login,
        public readonly string $symbol,
        public readonly float $volume,

        // Optional fields
        public readonly ?string $command = null,
        public readonly ?float $sl = null,
        public readonly ?float $tp = null,
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
            'login'  => $this->login,
            'symbol' => $this->symbol,
            'volume' => $this->volume,
        ];

        if ($this->command !== null) {
            $data['command'] = $this->command;
        }

        if ($this->sl !== null) {
            $data['sl'] = $this->sl;
        }

        if ($this->tp !== null) {
            $data['tp'] = $this->tp;
        }

        if ($this->comment !== null) {
            $data['comment'] = $this->comment;
        }

        return $data;
    }
}
