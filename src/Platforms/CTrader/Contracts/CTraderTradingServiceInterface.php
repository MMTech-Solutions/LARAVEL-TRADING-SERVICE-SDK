<?php

namespace Mmt\TradingServiceSdk\Platforms\CTrader\Contracts;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Mmt\TradingServiceSdk\Platforms\CTrader\Commands\CancelAllOpenOrdersCommand;
use Mmt\TradingServiceSdk\Platforms\CTrader\Commands\ChangePasswordCommand;
use Mmt\TradingServiceSdk\Platforms\CTrader\Commands\CheckPasswordCommand;
use Mmt\TradingServiceSdk\Platforms\CTrader\Commands\CloseAllPositionsCommand;
use Mmt\TradingServiceSdk\Platforms\CTrader\Commands\CloseAllTradingCommand;
use Mmt\TradingServiceSdk\Platforms\CTrader\Commands\ClosePositionCommand;
use Mmt\TradingServiceSdk\Platforms\CTrader\Commands\CreateUserCommand;
use Mmt\TradingServiceSdk\Platforms\CTrader\Commands\GetClosedPositionsCommand;
use Mmt\TradingServiceSdk\Platforms\CTrader\Commands\GetDealsHistoryCommand;
use Mmt\TradingServiceSdk\Platforms\CTrader\Commands\GetOrdersByTicketsCommand;
use Mmt\TradingServiceSdk\Platforms\CTrader\Commands\GetOrdersCommand;
use Mmt\TradingServiceSdk\Platforms\CTrader\Commands\GetPriceHistoryCommand;
use Mmt\TradingServiceSdk\Platforms\CTrader\Commands\ModifyPositionCommand;
use Mmt\TradingServiceSdk\Platforms\CTrader\Commands\OpenPositionCommand;
use Mmt\TradingServiceSdk\Platforms\CTrader\Commands\SetUserAccessCommand;
use Mmt\TradingServiceSdk\Platforms\CTrader\Commands\TransactionCommand;
use Mmt\TradingServiceSdk\Platforms\CTrader\Commands\UpdateUserCommand;
use Mmt\TradingServiceSdk\Platforms\CTrader\DTOs\AccountStateData;
use Mmt\TradingServiceSdk\Platforms\CTrader\DTOs\CheckPasswordData;
use Mmt\TradingServiceSdk\Platforms\CTrader\DTOs\ClosedPositionData;
use Mmt\TradingServiceSdk\Platforms\CTrader\DTOs\ClosePositionData;
use Mmt\TradingServiceSdk\Platforms\CTrader\DTOs\DealData;
use Mmt\TradingServiceSdk\Platforms\CTrader\DTOs\ExecutePositionData;
use Mmt\TradingServiceSdk\Platforms\CTrader\DTOs\GroupData;
use Mmt\TradingServiceSdk\Platforms\CTrader\DTOs\HierarchyGroupData;
use Mmt\TradingServiceSdk\Platforms\CTrader\DTOs\MarginLevelData;
use Mmt\TradingServiceSdk\Platforms\CTrader\DTOs\OrderData;
use Mmt\TradingServiceSdk\Platforms\CTrader\DTOs\PositionData;
use Mmt\TradingServiceSdk\Platforms\CTrader\DTOs\PriceData;
use Mmt\TradingServiceSdk\Platforms\CTrader\DTOs\PriceHistoryData;
use Mmt\TradingServiceSdk\Platforms\CTrader\DTOs\SymbolData;
use Mmt\TradingServiceSdk\Platforms\CTrader\DTOs\TransactionData;
use Mmt\TradingServiceSdk\Platforms\CTrader\DTOs\UserData;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\ActionResultInterface;

interface CTraderTradingServiceInterface
{
    // -------------------------------------------------------------------------
    // Server
    // -------------------------------------------------------------------------

    /**
     * @return ActionResultInterface<array>
     */
    public function getServerTime(): ActionResultInterface;

    // -------------------------------------------------------------------------
    // Users
    // -------------------------------------------------------------------------

    /**
     * @return ActionResultInterface<UserData[]>
     */
    public function listUsers(?string $groupFilter = null): ActionResultInterface;

    /**
     * @return ActionResultInterface<UserData>
     */
    public function getUser(string $login): ActionResultInterface;

    /**
     * @param  CreateUserCommand  $command
     * @return ActionResultInterface<UserData>
     */
    public function createUser(CommandInterface $command): ActionResultInterface;

    /**
     * @param  UpdateUserCommand  $command
     * @return ActionResultInterface<UserData>
     */
    public function updateUser(CommandInterface $command): ActionResultInterface;

    /**
     * @return ActionResultInterface<AccountStateData>
     */
    public function getAccountState(string $login): ActionResultInterface;

    /**
     * @param  SetUserAccessCommand  $command
     * @return ActionResultInterface<null>
     */
    public function setUserAccess(CommandInterface $command): ActionResultInterface;

    /**
     * @param  ChangePasswordCommand  $command
     * @return ActionResultInterface<null>
     */
    public function changePassword(CommandInterface $command): ActionResultInterface;

    /**
     * @param  CheckPasswordCommand  $command
     * @return ActionResultInterface<CheckPasswordData>
     */
    public function checkPassword(CommandInterface $command): ActionResultInterface;

    /**
     * @return ActionResultInterface<MarginLevelData>
     */
    public function getMarginLevel(string $login): ActionResultInterface;

    /**
     * @return ActionResultInterface<MarginLevelData[]>
     */
    public function getMarginLevels(CommandInterface $command): ActionResultInterface;

    /**
     * @return ActionResultInterface<MarginLevelData[]>
     */
    public function getMarginLevelsByOpenPositions(): ActionResultInterface;

    // -------------------------------------------------------------------------
    // Transactions
    // -------------------------------------------------------------------------

    /**
     * @param  TransactionCommand  $command
     * @return ActionResultInterface<TransactionData>
     */
    public function changeBalance(CommandInterface $command): ActionResultInterface;

    /**
     * @param  TransactionCommand  $command
     * @return ActionResultInterface<TransactionData>
     */
    public function setBalance(CommandInterface $command): ActionResultInterface;

    // -------------------------------------------------------------------------
    // Groups
    // -------------------------------------------------------------------------

    /**
     * @return ActionResultInterface<GroupData[]>
     */
    public function listGroups(): ActionResultInterface;

    /**
     * @return ActionResultInterface<HierarchyGroupData[]>
     */
    public function getGroupHierarchy(): ActionResultInterface;

    /**
     * @return ActionResultInterface<GroupData>
     */
    public function getGroup(string $name): ActionResultInterface;

    // -------------------------------------------------------------------------
    // Symbols
    // -------------------------------------------------------------------------

    /**
     * @return ActionResultInterface<SymbolData[]>
     */
    public function listSymbols(?string $groupFilter = null): ActionResultInterface;

    /**
     * @return ActionResultInterface<SymbolData>
     */
    public function getSymbol(string $name): ActionResultInterface;

    /**
     * @return ActionResultInterface<string[]>
     */
    public function getSymbolCategories(): ActionResultInterface;

    /**
     * @return ActionResultInterface<PriceData>
     */
    public function getLastPrice(string $name): ActionResultInterface;

    /**
     * @return ActionResultInterface<PriceData>
     */
    public function getPriceAt(string $name, int $timestamp): ActionResultInterface;

    /**
     * @param  GetPriceHistoryCommand  $command
     * @return ActionResultInterface<PriceHistoryData>
     */
    public function getPriceHistory(CommandInterface $command): ActionResultInterface;

    // -------------------------------------------------------------------------
    // Positions
    // -------------------------------------------------------------------------

    /**
     * @return ActionResultInterface<PositionData[]>
     */
    public function getAllPositions(): ActionResultInterface;

    /**
     * @return ActionResultInterface<PositionData[]>
     */
    public function getPositions(string $login): ActionResultInterface;

    /**
     * @return ActionResultInterface<PositionData>
     */
    public function getPosition(string $entityId): ActionResultInterface;

    /**
     * @param  OpenPositionCommand  $command
     * @return ActionResultInterface<ExecutePositionData>
     */
    public function openPosition(CommandInterface $command): ActionResultInterface;

    /**
     * @param  ModifyPositionCommand  $command
     * @return ActionResultInterface<null>
     */
    public function modifyPosition(CommandInterface $command): ActionResultInterface;

    /**
     * @param  ClosePositionCommand  $command
     * @return ActionResultInterface<ClosePositionData>
     */
    public function closePosition(CommandInterface $command): ActionResultInterface;

    /**
     * @param  CloseAllPositionsCommand  $command
     * @return ActionResultInterface<PositionData[]>
     */
    public function closeAllPositions(CommandInterface $command): ActionResultInterface;

    /**
     * @param  GetClosedPositionsCommand|null  $command
     * @return ActionResultInterface<ClosedPositionData[]>
     */
    public function getClosedPositions(?CommandInterface $command = null): ActionResultInterface;

    // -------------------------------------------------------------------------
    // Deals
    // -------------------------------------------------------------------------

    /**
     * @return ActionResultInterface<DealData>
     */
    public function getDeal(string $dealId): ActionResultInterface;

    /**
     * @return ActionResultInterface<DealData>
     */
    public function getOpenDeal(string $positionId): ActionResultInterface;

    /**
     * @return ActionResultInterface<DealData>
     */
    public function getCloseDeal(string $positionId): ActionResultInterface;

    /**
     * @return ActionResultInterface<DealData[]>
     */
    public function getAllDealsForPosition(string $positionId): ActionResultInterface;

    /**
     * @param  GetDealsHistoryCommand  $command
     * @return ActionResultInterface<DealData[]>
     */
    public function getDealsHistory(CommandInterface $command): ActionResultInterface;

    // -------------------------------------------------------------------------
    // Orders
    // -------------------------------------------------------------------------

    /**
     * @return ActionResultInterface<OrderData>
     */
    public function getOrder(string $orderId): ActionResultInterface;

    /**
     * @param  GetOrdersCommand  $command
     * @return ActionResultInterface<OrderData[]>
     */
    public function getOrders(CommandInterface $command): ActionResultInterface;

    /**
     * @param  GetOrdersByTicketsCommand  $command
     * @return ActionResultInterface<OrderData[]>
     */
    public function getOrdersByTickets(CommandInterface $command): ActionResultInterface;

    /**
     * Cancel all open (pending) orders for a login. Does not close positions.
     *
     * @param  CancelAllOpenOrdersCommand  $command
     * @return ActionResultInterface<string[]> Cancelled order ticket ids.
     */
    public function cancelAllOpenOrders(CommandInterface $command): ActionResultInterface;

    // -------------------------------------------------------------------------
    // Trading
    // -------------------------------------------------------------------------

    /**
     * Close all open positions and cancel all open orders for a login in parallel on the server.
     *
     * @param  CloseAllTradingCommand  $command
     * @return ActionResultInterface<array>
     */
    public function closeAllTrading(CommandInterface $command): ActionResultInterface;
}
