<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs;

class Asset
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $scale,
        public readonly string $type,
        public readonly string $source
    ) {}
}
