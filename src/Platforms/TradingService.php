<?php

namespace Mmt\TradingServiceSdk\Platforms;

use Mmt\TradingServiceSdk\Platforms\Shared\ObjectResponses\BrokerConnectionResponse;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\ResponseResult;
use Mmt\TradingServiceSdk\Platforms\Shared\Commands\ConnectBrokerCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Contracts\MT5TradingServiceInterface;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\TransportInterface;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\TransportPacket;

class TradingService
{
    public function __construct(
        private readonly TransportInterface $transport,
        private readonly MT5TradingServiceInterface $mt5TradingService,
    ) {}

    /**
     * @param ConnectBrokerCommand $command
     * @return ResponseResult<BrokerConnectionResponse>
     */
    public function createConnectionId(ConnectBrokerCommand $command): ResponseResult
    {
        $packet = new TransportPacket(
            endpoint: '/v1/admin/brokers/connect',
            payload: $command->toArray(),
            metadata: [
                'method' => 'post',
            ],
        );

        return $this->transport->send($packet);
    }

    public function mt5(): MT5TradingServiceInterface
    {
        return $this->mt5TradingService;
    }
}