<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\ObjectResponses;

use Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs\Account;

final class AccountGroupResponse
{
    public function __construct(
        public readonly string $user_id,
        /** @var Account[] */
        public readonly array $accounts,
    ) {}
}
