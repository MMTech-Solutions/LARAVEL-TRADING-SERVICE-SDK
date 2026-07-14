<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Override;

final class GetGroupsCommand implements CommandInterface
{
    public function __construct(
        public readonly string $user_id,
        public readonly ?int $limit = null,
        public readonly ?int $offset = null,
    ) {}

    #[Override]
    public function toArray(): array
    {
        $payload = [
            'user_id' => $this->user_id,
            'limit' => $this->limit,
            'offset' => $this->offset,
        ];

        return array_filter($payload, fn ($v) => ! is_null($v));
    }
}
