<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Contracts;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\ChangePasswordCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\CheckPasswordCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\CloseAllPositionsCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\ClosePositionCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\CreateUserCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\ExecutePositionCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\GetDealsHistoryCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\GetMarginLevelCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\GetMarginLevelsCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\GetOrdersByTicketsCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\GetOrdersCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\GetPriceHistoryCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\ListSymbolsCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\ModifyPositionCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\ListUsersCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\SetUserAccessCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\UpdateUserCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses\GroupItem;
use Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses\MarginLevelItem;
use Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses\PositionItem;
use Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses\ServerTime;
use Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses\SymbolItem;
use Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses\UserItem;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\ResponseResult;

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
     * @return ResponseResult<GroupItem>
     */
    public function getGroup(string $name): ResponseResult;

    /**
     * @param ?ListSymbolsCommand $command
     * @return ResponseResult<SymbolItem[]>
     */
    public function listSymbols(?CommandInterface $command = null): ResponseResult;

    /**
     * @return ResponseResult<SymbolItem>
     */
    public function getSymbol(string $name): ResponseResult;

    /**
     * @return ResponseResult<mixed>
     */
    public function getLastPrice(string $name): ResponseResult;

    /**
     * @return ResponseResult<mixed>
     */
    public function getPriceAt(string $name, int $timestamp): ResponseResult;

    /**
     * @param GetPriceHistoryCommand $command
     * @return ResponseResult<mixed>
     */
    public function getPriceHistory(CommandInterface $command): ResponseResult;

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
     * @param ExecutePositionCommand $command
     * @return ResponseResult<mixed>
     */
    public function executePosition(CommandInterface $command): ResponseResult;

    /**
     * @param ModifyPositionCommand $command
     * @return ResponseResult<mixed>
     */
    public function modifyPosition(CommandInterface $command): ResponseResult;

    /**
     * @param ClosePositionCommand $command
     * @return ResponseResult<mixed>
     */
    public function closePosition(CommandInterface $command): ResponseResult;

    /**
     * @param CloseAllPositionsCommand $command
     * @return ResponseResult<mixed>
     */
    public function closeAllPositions(CommandInterface $command): ResponseResult;

    /**
     * @return ResponseResult<PositionItem[]>
     */
    public function getPositions(string $login): ResponseResult;

    /**
     * @return ResponseResult<PositionItem>
     */
    public function getPosition(string $entityId): ResponseResult;

    /**
     * @return ResponseResult<mixed>
     */
    public function getDeal(string $dealId): ResponseResult;

    /**
     * @return ResponseResult<mixed>
     */
    public function getOpenDeal(string $positionId): ResponseResult;

    /**
     * @return ResponseResult<mixed>
     */
    public function getCloseDeal(string $positionId): ResponseResult;

    /**
     * @return ResponseResult<mixed>
     */
    public function getAllDealsForPosition(string $positionId): ResponseResult;

    /**
     * @param GetDealsHistoryCommand $command
     * @return ResponseResult<mixed>
     */
    public function getDealsHistory(CommandInterface $command): ResponseResult;

    /**
     * @return ResponseResult<mixed>
     */
    public function getOrder(string $orderId): ResponseResult;

    /**
     * @param GetOrdersByTicketsCommand $command
     * @return ResponseResult<mixed>
     */
    public function getOrdersByTickets(CommandInterface $command): ResponseResult;

    /**
     * @param GetOrdersCommand $command
     * @return ResponseResult<mixed>
     */
    public function getOrders(CommandInterface $command): ResponseResult;

    /**
     * @param ?ListUsersCommand $command
     * @return ResponseResult<UserItem[]>
     */
    public function listUsers(?CommandInterface $command = null): ResponseResult;

    /**
     * @param GetMarginLevelCommand $command
     * @return ResponseResult<MarginLevelItem>
     */
    public function getMarginLevel(CommandInterface $command): ResponseResult;

    public function getUser(string $login): ResponseResult;

    /**
     * @param UpdateUserCommand $command
     */
    public function updateUser(CommandInterface $command): ResponseResult;

    /**
     * @param ChangePasswordCommand $command
     */
    public function changePassword(CommandInterface $command): ResponseResult;

    /**
     * @param CheckPasswordCommand $command
     */
    public function checkPassword(CommandInterface $command): ResponseResult;

    /**
     * @param GetMarginLevelsCommand $command
     * @return ResponseResult<mixed>
     */
    public function getMarginLevels(CommandInterface $command): ResponseResult;

    /**
     * @return ResponseResult<mixed>
     */
    public function getMarginLevelsByOpenPositions(): ResponseResult;

    /**
     * @return ResponseResult<mixed>
     */
    public function getAccountState(string $login): ResponseResult;

    /**
     * @param SetUserAccessCommand $command
     */
    public function setUserAccess(CommandInterface $command): ResponseResult;
}
