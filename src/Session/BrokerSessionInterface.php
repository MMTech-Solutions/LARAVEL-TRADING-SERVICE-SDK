<?php

namespace Mmt\TradingServiceSdk\Session;

use Mmt\TradingServiceSdk\Platforms\B2Trader\Contracts\B2TTradingServiceInterface;
use Mmt\TradingServiceSdk\Platforms\CTrader\Contracts\CTraderTradingServiceInterface;
use Mmt\TradingServiceSdk\Platforms\MT5\Contracts\MT5TradingServiceInterface;

interface BrokerSessionInterface
{
    public function mt5(): MT5TradingServiceInterface;

    public function b2t(): B2TTradingServiceInterface;

    public function ctrader(): CTraderTradingServiceInterface;
}
