<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

final class HierarchyGroupItem
{
    public function __construct(
        public readonly string $name,
        public readonly bool $enabled,
        /** @var SymbolsCategoryItem[] */
        public readonly array $categories,
    ) {}
}