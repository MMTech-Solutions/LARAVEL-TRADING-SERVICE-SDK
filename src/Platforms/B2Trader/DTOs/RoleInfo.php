<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs;

class RoleInfo
{
    public function __construct(
        public string $id,
        public string $name,
    ) {}
}
