<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Override;

final class CreateAccountCommand implements CommandInterface
{
    public function __construct(
        public string $group_id,
        public string $name,
        public string $type
    ){}

    #[Override]
    public function toArray(): array
    {
        return [
            'group_id' => $this->group_id,
            'name' => $this->name,
            'type' => $this->type
        ];
    }
}