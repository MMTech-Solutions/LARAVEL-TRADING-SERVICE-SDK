<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Override;

class GetTickRangeCommand implements CommandInterface
{
    public function __construct(
        public readonly int $from_ts,
        public readonly int $to_ts,
        public readonly ?int $limit = null,
    ) {}

    #[Override]
    public function toArray(): array
    {
        $payload = [
            'from_ts' => $this->from_ts,
            'to_ts' => $this->to_ts,
            'limit' => $this->limit,
        ];

        return array_filter($payload, fn ($v) => ! is_null($v));
    }
}
