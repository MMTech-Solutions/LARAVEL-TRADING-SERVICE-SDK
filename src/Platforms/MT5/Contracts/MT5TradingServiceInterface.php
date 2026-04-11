<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Contracts;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\ListSymbolsCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\CreateUserCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses\PositionItem;
use Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses\ServerTime;
use Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses\SymbolItem;
use Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses\UserItem;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\ResponseResult;
use Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses\GroupItem;

interface MT5TradingServiceInterface
{
    /** 
     * @param ?ListSymbolsCommand $command
     * @return ResponseResult<string[]>
     */
    public function getSymbolCategories(?CommandInterface $command = null): ResponseResult;

    /**
     * @return ResponseResult<GroupItem[]>
     */
    public function listGroups(): ResponseResult;

    /**
     * @param ?ListSymbolsCommand $command
     * @return ResponseResult<SymbolItem[]>
     */
    public function listSymbols(?CommandInterface $command = null): ResponseResult;

    /**
     * @param CreateUserCommand $command
     */
    public function createUser(CommandInterface $command): ResponseResult;

    /**
     * @return ResponseResult<ServerTime>
     */
    public function getServerTime(): ResponseResult;


    /**
     * @return ResponseResult<PositionItem[]>
     */
    public function getAllPositions(): ResponseResult;

    /**
     * @param ?CommandInterface $command
     * @return ResponseResult<UserItem[]>
     */
    public function listUsers(?CommandInterface $command = null): ResponseResult;

    public function getMarginLevel(): ResponseResult;
}
