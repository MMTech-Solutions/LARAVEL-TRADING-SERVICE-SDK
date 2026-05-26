<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\ObjectResponses;

use Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs\Account;

final class AccountsByLoginResponse
{
    public function __construct(
        /** @var Account[] */
        public readonly array $accounts,
        /** @var string[] */
        public readonly array $missing_logins,
    ) {}
}
