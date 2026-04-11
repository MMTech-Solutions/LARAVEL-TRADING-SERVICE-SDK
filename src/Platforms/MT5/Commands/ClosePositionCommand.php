<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class ClosePositionCommand implements CommandInterface
{
    public function __construct(
        public string $position_id,
        public float $volume = 0.0,
        public ?string $comment = null,
    ) {}

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
