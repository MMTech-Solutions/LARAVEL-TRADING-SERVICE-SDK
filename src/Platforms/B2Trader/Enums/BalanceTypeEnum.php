<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Enums;

/**
 * Balance adjustment kind serialized on the wire as the JSON key "type".
 * Values: "BALANCE" (default Transfers deposit/withdraw) or "CREDIT" (native grant/revoke).
 */
enum BalanceTypeEnum: string
{
    case BALANCE = 'BALANCE';
    case CREDIT = 'CREDIT';
}
