<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $roleId
    ) {}

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'role_id' => $this->roleId
        ];
    }
}