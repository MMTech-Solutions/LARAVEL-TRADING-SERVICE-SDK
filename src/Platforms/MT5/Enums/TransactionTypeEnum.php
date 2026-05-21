<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Enums;

/**
 * Transaction type serialized on the wire as the JSON key "type".
 * Values are sent as strings: "BALANCE" or "CREDIT".
 */
enum TransactionTypeEnum: string
{
    case BALANCE = 'BALANCE';
    case CREDIT = 'CREDIT';
}
