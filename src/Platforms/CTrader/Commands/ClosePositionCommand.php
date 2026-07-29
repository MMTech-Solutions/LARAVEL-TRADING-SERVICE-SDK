<?php

namespace Mmt\TradingServiceSdk\Platforms\CTrader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Override;

/**
 * Command to close a specific open position on a CTrader account.
 *
 * Sends a POST request to /v1/ctrader/connections/{connection_id}/positions/close.
 */
class ClosePositionCommand implements CommandInterface
{
    public function __construct(
        // Required fields
        public readonly string $position_id,

        // Optional fields
        public readonly ?float $volume = null,
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
            'position_id' => $this->position_id,
        ];

        if ($this->volume !== null) {
            $data['volume'] = $this->volume;
        }

        if ($this->comment !== null) {
            $data['comment'] = $this->comment;
        }

        return $data;
    }
}
