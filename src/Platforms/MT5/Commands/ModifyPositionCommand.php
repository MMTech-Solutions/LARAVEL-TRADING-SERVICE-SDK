<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class ModifyPositionCommand implements CommandInterface
{
    public function __construct(
        public string $position_id,
        public float $sl = 0.0,
        public float $tp = 0.0,
    ) {}

    public function toArray(): array
    {
        return [
            'position_id' => $this->position_id,
            'sl' => $this->sl,
            'tp' => $this->tp,
        ];
    }
}
