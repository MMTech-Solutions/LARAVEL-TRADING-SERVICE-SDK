<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

use Mmt\TradingServiceSdk\WireHydration\Attributes\WireMapped;

#[WireMapped]
final class HierarchyGroupItem
{
    public function __construct(
        public readonly string $name,
        public readonly bool $enabled,
        public readonly string $currency,
        /** @var SymbolsCategoryItem[] */
        public readonly array $categories,
    ) {}
}
