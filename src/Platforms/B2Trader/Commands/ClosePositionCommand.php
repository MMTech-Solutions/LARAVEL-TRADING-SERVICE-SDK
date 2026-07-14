<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Override;

class ClosePositionCommand implements CommandInterface
{
    public function __construct(
        public readonly string $position_id,
        /** Volume to close (0 = close all). */
        public readonly float $volume = 0.0,
        public readonly ?string $comment = null
    ) {}

    #[Override]
    public function toArray(): array
    {
        $payload = [
            'position_id' => $this->position_id,
            'volume' => $this->volume,
            'comment' => $this->comment,
        ];

        return array_filter($payload, fn ($v) => ! is_null($v));
    }
}
