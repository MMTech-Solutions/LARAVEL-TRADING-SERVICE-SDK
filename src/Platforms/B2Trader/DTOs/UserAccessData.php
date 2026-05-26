<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs;

final class UserAccessData
{
    public function __construct(
        public readonly string $user_id,
        public readonly string $status,
    ) {}
}
