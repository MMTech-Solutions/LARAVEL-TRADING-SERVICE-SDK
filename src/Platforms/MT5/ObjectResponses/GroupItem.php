<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

class GroupItem
{
    public function __construct(
        public readonly string $name,
        public readonly bool $enabled,
        /** @var string[] */
        public readonly array $symbols_group
    ) {}
}