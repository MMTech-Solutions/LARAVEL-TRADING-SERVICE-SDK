<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Override;

class GetClosedPositionsCommand implements CommandInterface
{
    public function __construct(
        public readonly ?string $from_ts = null,
        public readonly ?string $to_ts = null,
        public readonly ?string $closed_from = null,
        public readonly ?string $closed_to = null,
        public readonly ?string $market_id = null,
        public readonly ?int $page_limit = null,
    ) {}

    #[Override]
    public function toArray(): array
    {
        $payload = [
            'from_ts' => $this->from_ts,
            'to_ts' => $this->to_ts,
            'closed_from' => $this->closed_from,
            'closed_to' => $this->closed_to,
            'market_id' => $this->market_id,
            'page_limit' => $this->page_limit,
        ];

        return array_filter($payload, fn ($v) => ! is_null($v));
    }
}
