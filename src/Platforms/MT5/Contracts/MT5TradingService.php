<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Contracts;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\ResponseResult;
use Mmt\TradingServiceSdk\Platforms\MT5\Contracts\MT5TradingServiceInterface;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\TransportInterface;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\TransportPacket;

class MT5TradingService implements MT5TradingServiceInterface
{
    private string $url = '/v1/mt5/connections';

    public function __construct(
        private readonly TransportInterface $transport
    ) {}

    public function getSymbolCategories(string $connectionId): ResponseResult
    {
        $url = $this->url.'/'.$connectionId.'/symbol-categories';
        return $this->sendPacket('get', $url);
    }

    public function listGroups(string $connectionId): ResponseResult
    {
        $url = $this->url.'/'.$connectionId.'/groups';
        return $this->sendPacket('get', $url);
    }
    
    public function createUser(string $connectionId, CommandInterface $command): ResponseResult
    {
        return $this->sendPacket('post', $this->url.'/'.$connectionId.'/users', $command->toArray());
    }

    public function getServerTime(string $connectionId): ResponseResult
    {
        return $this->sendPacket('get', $this->url.'/'.$connectionId.'/server-time');
    }

    public function listSymbols(string $connectionId, ?CommandInterface $command = null): ResponseResult
    {
        return $this->sendPacket('get', $this->url.'/'.$connectionId.'/symbols', $command?->toArray() ?? []);
    }

    public function getAllPositions(string $connectionId): ResponseResult
    {
        return $this->sendPacket('get', $this->url.'/'.$connectionId.'/positions/all');
    }

    private function sendPacket(string $method, string $url, array $payload = []): ResponseResult
    {
        $packet = new TransportPacket(
            endpoint: $url,
            payload: $payload,
            metadata: [
                'method' => $method,
            ],
        );

        return $this->transport->send($packet);
    }
}