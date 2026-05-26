<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs;

final class UserProfile
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly string $role_id,
        public readonly string $status,
        public readonly string $created_at,
        public readonly string $updated_at,
    ) {}
}
