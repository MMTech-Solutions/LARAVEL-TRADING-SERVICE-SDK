<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Contracts;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\ListSymbolsCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\CreateUserCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses\PositionItem;
use Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses\ServerTime;
use Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses\SymbolItem;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\ResponseResult;
use Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses\GroupItem;

interface MT5TradingServiceInterface
{
    /**
     * @return ResponseResult<string[]>
     */
    public function getSymbolCategories(string $connectionId): ResponseResult;

    /**
     * @return ResponseResult<GroupItem[]>
     */
    public function listGroups(string $connectionId): ResponseResult;

    /**
     * @param ?ListSymbolsCommand $command
     * @return ResponseResult<SymbolItem[]>
     */
    public function listSymbols(string $connectionId, ?CommandInterface $command = null): ResponseResult;

    /**
     * @param CreateUserCommand $command
     */
    public function createUser(string $connectionId, CommandInterface $command): ResponseResult;

    /**
     * @return ResponseResult<ServerTime>
     */
    public function getServerTime(string $connectionId): ResponseResult;


    /**
     * @return ResponseResult<PositionItem[]>
     */
    public function getAllPositions(string $connectionId): ResponseResult;


    // public function processBalanceOperation(string $connectionId, CommandInterface $command);
}