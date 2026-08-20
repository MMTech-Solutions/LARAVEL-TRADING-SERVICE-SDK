<?php

namespace Tests\Unit\Platforms\MT5;

use Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses\SymbolsCategoryItem;
use Mmt\TradingServiceSdk\WireHydration\WireHydrator;
use PHPUnit\Framework\TestCase;

class SymbolsCategoryItemHydrationTest extends TestCase
{
    public function test_hydrates_nested_categories_recursively(): void
    {
        $category = (new WireHydrator())->hydrate([
            'category' => 'Shares',
            'symbols' => [],
            'categories' => [[
                'category' => 'Shares Asia',
                'symbols' => [],
                'categories' => [[
                    'category' => 'Qatar',
                    'symbols' => [],
                    'categories' => [],
                ]],
            ]],
        ], SymbolsCategoryItem::class);

        $this->assertSame('Shares Asia', $category->categories[0]->category);
        $this->assertSame('Qatar', $category->categories[0]->categories[0]->category);
    }
}
