<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Enums;

/** Serialized on the wire as JSON key "type". */
enum TransactionTypeEnum: int
{
    case BALANCE = 1;
    case CREDIT = 2;
}
