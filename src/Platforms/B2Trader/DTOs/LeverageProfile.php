<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs;

class LeverageProfile
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly int $value,
        public readonly bool $is_default,
    ) {}
}
