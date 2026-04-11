<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Mmt\TradingServiceSdk\Platforms\MT5\Enums\PositionTradeCommandEnum;

/** Payload for POST /positions/execute; market side uses {@see PositionTradeCommandEnum}. */
class ExecutePositionCommand implements CommandInterface
{
    public function __construct(
        public string $login,
        public string $symbol,
        public PositionTradeCommandEnum $command = PositionTradeCommandEnum::BUY,
        public float $volume = 0.01,
        public float $sl = 0.0,
        public float $tp = 0.0,
        public ?string $comment = null,
    ) {}

    public function toArray(): array
    {
        $payload = [
            'login' => $this->login,
            'symbol' => $this->symbol,
            'command' => $this->command->name,
            'volume' => $this->volume,
            'sl' => $this->sl,
            'tp' => $this->tp,
            'comment' => $this->comment,
        ];

        return array_filter($payload, fn ($v) => ! is_null($v));
    }
}
