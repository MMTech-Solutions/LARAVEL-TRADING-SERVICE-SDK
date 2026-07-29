<?php

declare(strict_types=1);

namespace Mmt\TradingServiceSdk\Platforms\CTrader\DTOs;

/**
 * Represents a node in the CTrader group hierarchy tree,
 * which may contain nested child group categories.
 */
final readonly class HierarchyGroupData
{
    public function __construct(
        public ?string $name = null,
        public ?bool $enabled = null,
        public ?string $currency = null,
        public mixed $categories = null,
    ) {}
}
