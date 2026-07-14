<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Override;

class UpdatePositionCommand implements CommandInterface
{
    public function __construct(
        public readonly string $position_id,
        /** New Stop Loss (0 = remove). */
        public readonly float $sl,
        /** New Take Profit (0 = remove). */
        public readonly float $tp
    ) {}

    #[Override]
    public function toArray(): array
    {
        return [
            'position_id' => $this->position_id,
            'sl' => $this->sl,
            'tp' => $this->tp,
        ];
    }
}
