<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Override;

final class ChangePasswordCommand implements CommandInterface
{
    public function __construct(
        public readonly string $login,
        public readonly string $new_password,
        public readonly bool $is_investor,
    ){}

    #[Override]
    public function toArray(): array
    {
        return [
            'login' => $this->login,
            'new_password' => $this->new_password,
            'is_investor' => $this->is_investor
        ];
    }
}