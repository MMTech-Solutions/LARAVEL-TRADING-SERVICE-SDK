<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Mmt\TradingServiceSdk\Platforms\B2Trader\Enums\OpenPositionCommandEnum;
use Override;

class OpenPositionCommand implements CommandInterface
{
    public function __construct(
        public readonly string $login,
        public readonly string $symbol,
        public readonly OpenPositionCommandEnum $command,
        public readonly float $volume,
        public readonly float $sl,
        public readonly float $tp,
        public readonly ?string $comment = null
    ){}

    #[Override]
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