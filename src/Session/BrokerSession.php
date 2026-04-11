<?php

namespace Mmt\TradingServiceSdk\Session;

use Mmt\TradingServiceSdk\Platforms\MT5\Contracts\MT5TradingServiceInterface;

class BrokerSession implements BrokerSessionInterface
{
    public function __construct(
        private readonly string $connectionId
    ) {}

    public function mt5(): MT5TradingServiceInterface
    {
        return resolve(MT5TradingServiceInterface::class, [
            'connectionId' => $this->connectionId,
        ]);
    }
}