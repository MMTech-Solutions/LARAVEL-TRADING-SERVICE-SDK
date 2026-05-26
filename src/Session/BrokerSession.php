<?php

namespace Mmt\TradingServiceSdk\Session;

use Mmt\TradingServiceSdk\Platforms\B2Trader\Contracts\B2TTradingServiceInterface;
use Mmt\TradingServiceSdk\Platforms\MT5\Contracts\MT5TradingServiceInterface;
use Override;

class BrokerSession implements BrokerSessionInterface
{
    public function __construct(
        private readonly string $connectionId
    ) {}

    #[Override]
    public function mt5(): MT5TradingServiceInterface
    {
        return resolve(MT5TradingServiceInterface::class, [
            'connectionId' => $this->connectionId,
        ]);
    }

    #[Override]
    public function b2t(): B2TTradingServiceInterface
    {
        return resolve(
            B2TTradingServiceInterface::class,
            ['connectionId' => $this->connectionId]
        );
    }
}