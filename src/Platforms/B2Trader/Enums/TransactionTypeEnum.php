<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Enums;

enum TransactionTypeEnum: string
{
    case DEPOSIT = 'deposit';
    case WITHDRAWAL = 'withdrawal';
}