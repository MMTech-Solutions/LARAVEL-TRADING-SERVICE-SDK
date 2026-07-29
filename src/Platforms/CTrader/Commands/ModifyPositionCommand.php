<?php

namespace Mmt\TradingServiceSdk\Platforms\CTrader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Override;

/**
 * Command to modify the stop-loss and/or take-profit of an open position.
 *
 * Sends a PATCH request to /v1/ctrader/connections/{connection_id}/positions.
 */
class ModifyPositionCommand implements CommandInterface
{
    public function __construct(
        // Required fields
        public readonly string $position_id,

        // Optional fields
        public readonly ?float $sl = null,
        public readonly ?float $tp = null,
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
            'position_id' => $this->position_id,
        ];

        if ($this->sl !== null) {
            $data['sl'] = $this->sl;
        }

        if ($this->tp !== null) {
            $data['tp'] = $this->tp;
        }

        return $data;
    }
}
