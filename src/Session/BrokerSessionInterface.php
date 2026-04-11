<?php

namespace Mmt\TradingServiceSdk\Session;

use Mmt\TradingServiceSdk\Platforms\MT5\Contracts\MT5TradingServiceInterface;

interface BrokerSessionInterface
{
    public function mt5(): MT5TradingServiceInterface;
}