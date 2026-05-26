<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\ObjectResponses;

use Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs\GroupInfo;

class GroupsResponse
{
    public function __construct(
        public readonly string $default_account_group_id,
        public readonly string $default_account_group_name,
        /** @var GroupInfo[] */
        public readonly array $account_groups,
    ) {}
}
