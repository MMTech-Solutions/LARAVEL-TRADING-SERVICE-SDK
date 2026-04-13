<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

final class AccountStateItem
{
    public function __construct(
        public string $login,
        /** @see AccessLevelEnum::lowerCases() */
        public string $access
    ) {}
}
