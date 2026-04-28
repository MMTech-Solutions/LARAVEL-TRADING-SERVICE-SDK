<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

final class SymbolsCategoryItem
{
    public function __construct(
        public readonly string $category,
        /** @var SymbolItem[] */
        public readonly array $symbols,
    ) {}
}