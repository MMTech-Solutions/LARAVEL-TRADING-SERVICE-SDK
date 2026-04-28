<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Contracts;

use Mmt\TradingServiceSdk\Platforms\MT5\Commands\{
    ChangePasswordCommand, CheckPasswordCommand, CloseAllPositionsCommand, ClosePositionCommand, CreateUserCommand,
    GetDealsHistoryCommand, GetMarginLevelCommand, GetMarginLevelsCommand, GetOrdersByTicketsCommand, GetOrdersCommand,
    GetPriceHistoryCommand, ListSymbolsCommand, ModifyPositionCommand, ListUsersCommand, OpenPositionCommand,
    SetUserAccessCommand, TransactionCommand, UpdateUserCommand
};
use Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses\{
    AccountStateItem, CloseAllPositionItem, DealItem, GroupItem,
    HierarchyGroupItem, MarginLevelItem, OpenPositionItem, OrderItem,
    PositionCloseItem, PositionItem, ServerTime, SymbolItem,
    TransactionItem, UserItem, PriceItem, PriceHistoryItem
};

use Mmt\TradingServiceSdk\TransportDrivers\Contracts\ActionResultInterface;
use Mmt\TradingServiceSdk\Contracts\CommandInterface;

interface MT5TradingServiceInterface
{
    /**
     * @param ?ListSymbolsCommand $command
     * @return ActionResultInterface<string[]>
     */
    public function getSymbolCategories(?CommandInterface $command = null): ActionResultInterface;

    /**
     * @return ActionResultInterface<GroupItem[]>
     */
    public function listGroups(): ActionResultInterface;

    /**
     * @return ActionResultInterface<GroupItem>
     */
    public function getGroup(string $name): ActionResultInterface;

    /**
     * @param ?ListSymbolsCommand $command
     * @return ActionResultInterface<SymbolItem[]>
     */
    public function listSymbols(?CommandInterface $command = null): ActionResultInterface;

    /**
     * @return ActionResultInterface<SymbolItem>
     */
    public function getSymbol(string $name): ActionResultInterface;

    /**
     * @return ActionResultInterface<PriceItem>
     */
    public function getLastPrice(string $name): ActionResultInterface;

    /**
     * @return ActionResultInterface<PriceItem>
     */
    public function getPriceAt(string $name, int $timestamp): ActionResultInterface;

    /**
     * @param GetPriceHistoryCommand $command
     * @return ActionResultInterface<PriceHistoryItem>
     */
    public function getPriceHistory(CommandInterface $command): ActionResultInterface;

    /**
     * @param CreateUserCommand $command
     * @return ActionResultInterface<UserItem>
     */
    public function createUser(CommandInterface $command): ActionResultInterface;

    /**
     * @return ActionResultInterface<ServerTime>
     */
    public function getServerTime(): ActionResultInterface;

    /**
     * @return ActionResultInterface<PositionItem[]>
     */
    public function getAllPositions(): ActionResultInterface;

    /**
     * @param OpenPositionCommand $command
     * @return ActionResultInterface<OpenPositionItem>
     */
    public function openPosition(CommandInterface $command): ActionResultInterface;

    /**
     * @param ModifyPositionCommand $command
     * @return ActionResultInterface<null>
     */
    public function modifyPosition(CommandInterface $command): ActionResultInterface;

    /**
     * @param ClosePositionCommand $command
     * @return ActionResultInterface<PositionCloseItem>
     */
    public function closePosition(CommandInterface $command): ActionResultInterface;

    /**
     * @param CloseAllPositionsCommand $command
     * @return ActionResultInterface<CloseAllPositionItem[]>
     */
    public function closeAllPositions(CommandInterface $command): ActionResultInterface;

    /**
     * @return ActionResultInterface<PositionItem[]>
     */
    public function getPositions(string $login): ActionResultInterface;

    /**
     * @return ActionResultInterface<PositionItem>
     */
    public function getPosition(string $entityId): ActionResultInterface;

    /**
     * @return ActionResultInterface<DealItem>
     */
    public function getDeal(string $dealId): ActionResultInterface;

    /**
     * @return ActionResultInterface<DealItem>
     */
    public function getOpenDeal(string $positionId): ActionResultInterface;

    /**
     * @return ActionResultInterface<DealItem>
     */
    public function getCloseDeal(string $positionId): ActionResultInterface;

    /**
     * @return ActionResultInterface<DealItem[]>
     */
    public function getAllDealsForPosition(string $positionId): ActionResultInterface;

    /**
     * @param GetDealsHistoryCommand $command
     * @return ActionResultInterface<DealItem[]>
     */
    public function getDealsHistory(CommandInterface $command): ActionResultInterface;

    /**
     * @return ActionResultInterface<OrderItem>
     */
    public function getOrder(string $orderId): ActionResultInterface;

    /**
     * @param GetOrdersByTicketsCommand $command
     * @return ActionResultInterface<OrderItem[]>
     */
    public function getOrdersByTickets(CommandInterface $command): ActionResultInterface;

    /**
     * @param GetOrdersCommand $command
     * @return ActionResultInterface<OrderItem[]>
     */
    public function getOrders(CommandInterface $command): ActionResultInterface;

    /**
     * @param ?ListUsersCommand $command
     * @return ActionResultInterface<UserItem[]>
     */
    public function listUsers(?CommandInterface $command = null): ActionResultInterface;

    /**
     * @param GetMarginLevelCommand $command
     * @return ActionResultInterface<MarginLevelItem>
     */
    public function getMarginLevel(CommandInterface $command): ActionResultInterface;

    /**
     * @return ActionResultInterface<UserItem>
     */
    public function getUser(string $login): ActionResultInterface;

    /**
     * @param UpdateUserCommand $command
     * @return ActionResultInterface<UserItem>
     */
    public function updateUser(CommandInterface $command): ActionResultInterface;

    /**
     * @param ChangePasswordCommand $command
     * @return ActionResultInterface<null>
     */
    public function changePassword(CommandInterface $command): ActionResultInterface;

    /**
     * @param CheckPasswordCommand $command
     * @return ActionResultInterface<null>
     */
    public function checkPassword(CommandInterface $command): ActionResultInterface;

    /**
     * @param GetMarginLevelsCommand $command
     * @return ActionResultInterface<MarginLevelItem[]>
     */
    public function getMarginLevels(CommandInterface $command): ActionResultInterface;

    /**
     * @return ActionResultInterface<MarginLevelItem>
     */
    public function getMarginLevelsByOpenPositions(): ActionResultInterface;

    /**
     * @return ActionResultInterface<AccountStateItem>
     */
    public function getAccountState(string $login): ActionResultInterface;

    /**
     * @param SetUserAccessCommand $command
     * @return ActionResultInterface<null>
     */
    public function setUserAccess(CommandInterface $command): ActionResultInterface;

    /**
     * @param TransactionCommand $command
     * @return ActionResultInterface<TransactionItem>
     */
    public function changeBalance(CommandInterface $command): ActionResultInterface;

    /**
     * @param TransactionCommand $command
     * @return ActionResultInterface<TransactionItem>
     */
    public function setBalance(CommandInterface $command): ActionResultInterface;

    /**
     * @return ActionResultInterface<HierarchyGroupItem[]>
     */
    public function getGroupHierarchy(): ActionResultInterface;
}
