<?php

namespace Mmt\TradingServiceSdk\Platforms;

use Mmt\TradingServiceSdk\Platforms\Shared\ObjectResponses\BrokerConnectionResponse;
use Mmt\TradingServiceSdk\Session\BrokerSession;
use Mmt\TradingServiceSdk\Session\BrokerSessionInterface;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\ActionResultInterface;
use Mmt\TradingServiceSdk\Platforms\Shared\Commands\ConnectBrokerCommand;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\TransportInterface;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\TransportPacket;

class TradingService
{
    public function __construct(
        private readonly TransportInterface $transport,
    ) {}


    /**
     * @param ConnectBrokerCommand $command
     * @param string|null $connectionId
     * @return BrokerSessionInterface
     * @throws \Exception If the connection fails
     */
    public function connect(ConnectBrokerCommand $command, ?string &$connectionId = null): BrokerSessionInterface
    {
        $response = $this->createConnectionId($command);

        if( !$response->isSuccess() ) {
            throw new \Exception('Failed to create connection');
        }

        $data = $response->getData(BrokerConnectionResponse::class);

        $connectionId = $data->connection_id;

        return new BrokerSession(
            connectionId: $data->connection_id
        );
    }

    public function fromConnectionId(string $connectionId): BrokerSessionInterface
    {
        return new BrokerSession(
            connectionId: $connectionId
        );
    }

    public function disconnect(string $connectionId): void
    {
        $packet = new TransportPacket(
            endpoint: '/v1/admin/brokers/disconnect',
            payload: [
                'connection_id' => $connectionId,
            ],
            metadata: [
                'method' => 'post',
            ],
        );

        $this->transport->send($packet);
    }

    /**
     * @param ConnectBrokerCommand $command
     * @return ActionResultInterface<BrokerConnectionResponse>
     */
    private function createConnectionId(ConnectBrokerCommand $command): ActionResultInterface
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

}