<?php

namespace Mmt\TradingServiceSdk\Platforms;

use Exception;
use Mmt\TradingServiceSdk\Platforms\Shared\Commands\ConnectBrokerCommand;
use Mmt\TradingServiceSdk\Platforms\Shared\ObjectResponses\BrokerConnectionResponse;
use Mmt\TradingServiceSdk\Session\BrokerSession;
use Mmt\TradingServiceSdk\Session\BrokerSessionInterface;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\ActionResultInterface;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\TransportInterface;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\TransportPacket;

class TradingService
{
    public function __construct(
        private readonly TransportInterface $transport,
    ) {}

    /**
     * Connect to a broker and return a session.
     *
     * Hits POST /v1/admin/brokers/connect/{platform} — the platform slug is derived
     * from the command's platform_type and placed in the URL path, not the body.
     *
     * @throws Exception If the connection fails.
     */
    public function connect(ConnectBrokerCommand $command, ?string &$connectionId = null): BrokerSessionInterface
    {
        $response = $this->createConnectionId($command);

        if (! $response->isSuccess()) {
            throw new Exception('Failed to create connection');
        }

        $data = $response->getData(BrokerConnectionResponse::class);

        $connectionId = $data->connection_id;

        return new BrokerSession(
            connectionId: $data->connection_id
        );
    }

    /**
     * Build a session from an existing connection id without hitting the API.
     */
    public function fromConnectionId(string $connectionId): BrokerSessionInterface
    {
        return new BrokerSession(
            connectionId: $connectionId
        );
    }

    /**
     * Disconnect an active broker connection.
     */
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
     * POST /v1/admin/brokers/connect/{platform}
     *
     * The platform slug (e.g. "mt5") is appended to the URL path.
     * The body contains only connection credentials — no platform_type field.
     *
     * @return ActionResultInterface<BrokerConnectionResponse>
     */
    private function createConnectionId(ConnectBrokerCommand $command): ActionResultInterface
    {
        $platform = $command->platformSlug();

        $packet = new TransportPacket(
            endpoint: "/v1/admin/brokers/connect/{$platform}",
            payload: $command->toArray(),
            metadata: [
                'method' => 'post',
            ],
        );

        return $this->transport->send($packet);
    }
}