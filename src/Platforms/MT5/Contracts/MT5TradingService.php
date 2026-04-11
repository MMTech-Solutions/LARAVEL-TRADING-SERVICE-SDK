<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Contracts;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\ListSymbolsCommand;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\ResponseResult;
use Mmt\TradingServiceSdk\Platforms\MT5\Contracts\MT5TradingServiceInterface;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\TransportInterface;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\TransportPacket;


class MT5TradingService implements MT5TradingServiceInterface
{
    private string $url = '/v1/mt5/connections';

    public function __construct(
        private readonly string $connectionId,
        private readonly TransportInterface $transport
    ) {}


    /**
     * @param ?ListSymbolsCommand $command
     * @return ResponseResult<string[]>
     */
    public function getSymbolCategories(?CommandInterface $command = null): ResponseResult
    {
        $url = $this->url.'/'.$this->connectionId.'/symbol-categories';
        return $this->sendPacket('get', $url, $command?->toArray() ?? []);
    }

    public function listGroups(): ResponseResult
    {
        $url = $this->url.'/'.$this->connectionId.'/groups';
        return $this->sendPacket('get', $url);
    }
    
    public function createUser(CommandInterface $command): ResponseResult
    {
        return $this->sendPacket('post', $this->url.'/'.$this->connectionId.'/users', $command->toArray());
    }

    public function getServerTime(): ResponseResult
    {
        return $this->sendPacket('get', $this->url.'/'.$this->connectionId.'/server-time');
    }

    public function listSymbols(?CommandInterface $command = null): ResponseResult
    {
        return $this->sendPacket('get', $this->url.'/'.$this->connectionId.'/symbols', $command?->toArray() ?? []);
    }

    public function getAllPositions(): ResponseResult
    {
        return $this->sendPacket('get', $this->url.'/'.$this->connectionId.'/positions/all');
    }

    public function listUsers(?CommandInterface $command = null): ResponseResult
    {
        return $this->sendPacket('get', $this->url.'/'.$this->connectionId.'/users', $command?->toArray() ?? []);
    }

    public function getMarginLevel(): ResponseResult
    {
        return $this->sendPacket('get', $this->url.'/'.$this->connectionId.'/margin-level');
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