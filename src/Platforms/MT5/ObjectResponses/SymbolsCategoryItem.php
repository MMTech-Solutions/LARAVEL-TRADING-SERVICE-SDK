<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

use Mmt\TradingServiceSdk\WireHydration\Attributes\WireMapped;

#[WireMapped]
final class SymbolsCategoryItem
{
    public function __construct(
        public readonly string $category,
        /** @var SymbolItem[] */
        public readonly array $symbols,
    ) {}
}
