<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\ObjectResponses;

use Mmt\TradingServiceSdk\WireHydration\Attributes\WireMapped;

#[WireMapped]
class GroupsResponse
{
    public function __construct(
        public readonly string $default_account_group_id,
        public readonly string $default_account_group_name,
        /** @var \Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs\GroupInfo[] */
        public readonly array $account_groups,
    ) {}
}
