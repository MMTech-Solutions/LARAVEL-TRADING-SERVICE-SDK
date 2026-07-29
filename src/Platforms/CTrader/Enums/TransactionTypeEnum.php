<?php

namespace Mmt\TradingServiceSdk\Platforms\CTrader\Enums;

/**
 * Represents the type of a CTrader balance transaction.
 */
enum TransactionTypeEnum: string
{
    case Deposit    = 'deposit';
    case Withdrawal = 'withdrawal';
}
