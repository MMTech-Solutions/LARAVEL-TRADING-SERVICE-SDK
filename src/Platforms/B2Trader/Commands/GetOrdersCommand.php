<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Override;

class GetOrdersCommand implements CommandInterface
{
    public function __construct(
        public string $login,
        public ?string $from_timestamp = null,
        public ?string $to_timestamp = null
    ){}

    #[Override]
    public function toArray(): array
    {
        $payload = [
            'login' => $this->login,
            'from_timestamp' => $this->from_timestamp,
            'to_timestamp' => $this->to_timestamp
        ];

        return array_filter($payload, fn($v) => ! is_null($v));
    }
}