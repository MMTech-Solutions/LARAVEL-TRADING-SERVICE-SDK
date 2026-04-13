<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

final class TransactionItem
{
    public function __construct(
        public string $ticket,
        public string|float $new_balance
    ){}
}