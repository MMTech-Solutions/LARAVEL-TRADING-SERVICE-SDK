<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Contracts;

use Mmt\TradingServiceSdk\TransportDrivers\Contracts\ActionResultInterface;
use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Mmt\TradingServiceSdk\Platforms\B2Trader\Commands\{
    ChangePasswordCommand, ClosePositionCommand,
    CreateAccountCommand, CreateUserCommand,
    GetTransferHistoryCommand, GetClosedPositionsCommand, GetDealsHistoryCommand,
    GetGroupsCommand, GetOrdersCommand, GetTickRangeCommand,
    OpenPositionCommand, SetAccountAccessCommand, TransactionCommand, UpdatePositionCommand
};
use Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs\{
    Account, AccountAccessData, AccountState, Asset, BulkClosedPosition, DealInfo, GroupInfo, LeverageProfile, MarginLevel, Order,
    Position, RoleInfo, SymbolInfo, TickInfo, TransactionHistoryItem, UserAccessData, UserProfile
};
use Mmt\TradingServiceSdk\Platforms\B2Trader\ObjectResponses\{
    AccountGroupResponse, AccountsByLoginResponse, AddBalanceResponse, CloseAllPositionsResponse,
    ClosedPositionsResponse, ClosePositionResponse, GroupsResponse, OpenPositionResponse,
    ServerTimeResponse, SetBalanceResponse
};

interface B2TTradingServiceInterface
{
    /**
     * @return ActionResultInterface<ServerTimeResponse>
     */
    public function getServerTime(): ActionResultInterface;

    #region User and profile management

        /**
         * @param CreateUserCommand $command
         * @return ActionResultInterface<UserProfile>
         */
        public function createUser(CommandInterface $command): ActionResultInterface;

        /**
         * @return ActionResultInterface<UserProfile[]>
         */
        public function listUsers(string $groupFilter) : ActionResultInterface;

        /**
         * @param ChangePasswordCommand $command
         * @return ActionResultInterface<null>
         */
        public function changePassword(CommandInterface $command): ActionResultInterface;

        /**
         * @return ActionResultInterface<null>
         */
        public function setUserAccess(string $login, string $access): ActionResultInterface;

        /**
         * @param SetAccountAccessCommand $command
         * @return ActionResultInterface<null>
         */
        public function setAccountAccess(CommandInterface $command): ActionResultInterface;

        /**
         * @return ActionResultInterface<AccountAccessData>
         */
        public function getAccountAccess(string $login): ActionResultInterface;

        /**
         * @return ActionResultInterface<UserProfile[]>
         */
        public function getUsersByIds(string $user_id, string ...$user_ids): ActionResultInterface;

        /**
         * @return ActionResultInterface<UserProfile>
         */
        public function getUser(string $user_id): ActionResultInterface;

        /**
         * @return ActionResultInterface<UserProfile>
         */
        public function getUserByLogin(string $login): ActionResultInterface;

        /**
         * @return ActionResultInterface<UserProfile>
         */
        public function getUserByEmail(string $email): ActionResultInterface;

        /**
         * @return ActionResultInterface<UserAccessData>
         */
        public function getUserAccess(string $user_id): ActionResultInterface;

    #endregion

    #region Account and margin ops

        /**
         * @return ActionResultInterface<AccountState>
         */
        public function getAccountState(string $login): ActionResultInterface;

        /**
         * @param string $login
         * @return ActionResultInterface<MarginLevel>
         */
        public function getMarginLevel(string $login): ActionResultInterface;

        /**
         * @return ActionResultInterface<MarginLevel[]>
         */
        public function getMarginLevels(string $login, string ...$logins): ActionResultInterface;

        /**
         * @return ActionResultInterface<MarginLevel>
         */
        public function getMarginLevelsWithOpenPositions(): ActionResultInterface;

        /**
         * @param string $user_id
         * @return ActionResultInterface<Account[]>
         */
        public function getAccountsByUserId(string $user_id): ActionResultInterface;

        /**
         * @param CreateAccountCommand $command
         * @return ActionResultInterface<Account>
         */
        public function createAccount(string $userId, CommandInterface $command): ActionResultInterface;

        /**
         * @return ActionResultInterface<Account>
         */
        public function getAccount(string $login): ActionResultInterface;

        /**
         * @return ActionResultInterface<AccountsByLoginResponse>
         */
        public function getAccounts(string $login, string ...$logins): ActionResultInterface;

        /**
         * @return ActionResultInterface<AccountGroupResponse>
         */
        public function getAccountsByUserIds(string $user_id, string ...$user_ids): ActionResultInterface;

        /**
         * @return ActionResultInterface<CloseAllPositionsResponse>
         */
        public function closePositionsAndCancelOpenOrders(string $login, ?string $symbolFilter = null): ActionResultInterface;

        /**
         * @return ActionResultInterface<TransactionHistoryItem[]>
         */
        public function getAccountTransfersHistory(string $login, GetTransferHistoryCommand $command): ActionResultInterface;

    #endregion

    #region Cash ops

        /**
         * B2Trader deposit or withdrawal via Transfers API.
         * Positive amount -> deposits;
         * Negative amount -> withdraws.
         * Withdrawals are **auto-confirmed** when transfer status is `AwaitingConfirmation`
         * 
         * @param TransactionCommand $command
         * @return ActionResultInterface<AddBalanceResponse>
         */
        public function addBalance(CommandInterface $command): ActionResultInterface;

        /**
         * @param TransactionCommand $command
         * @return ActionResultInterface<SetBalanceResponse>
         */
        public function setBalance(CommandInterface $command): ActionResultInterface;

        /**
         * @return ActionResultInterface<TransactionHistoryItem[]>
         */
        public function getTransactionDetails(string $transaction_id): ActionResultInterface;

    #endregion

    #region Position and risk management

        /**
         * @return ActionResultInterface<Position[]>
         */
        public function getAllPositions(): ActionResultInterface;

        /**
         * @param GetClosedPositionsCommand|null $command
         * @return ActionResultInterface<ClosedPositionsResponse>
         */
        public function getClosedPositions(string $login, ?CommandInterface $command = null): ActionResultInterface;

        /**
         * @return ActionResultInterface<Position[]>
         */
        public function getPositions(string $login): ActionResultInterface;

        /**
         * @param UpdatePositionCommand $command
         * @return ActionResultInterface<null>
         */
        public function updatePosition(CommandInterface $command): ActionResultInterface;

        /**
         * @return ActionResultInterface<Position>
         */
        public function getPosition(string $login): ActionResultInterface;

        /**
         * @param OpenPositionCommand $command
         * @return ActionResultInterface<OpenPositionResponse>
         */
        public function openPosition(CommandInterface $command): ActionResultInterface;

        /**
         * @param ClosePositionCommand $command
         * @return ActionResultInterface<ClosePositionResponse>
         */
        public function closePosition(CommandInterface $command): ActionResultInterface;

        /**
         * @return ActionResultInterface<BulkClosedPosition[]>
         */
        public function closeAllPositions(string $login, ?string $symbol_filter = null): ActionResultInterface;

        /**
         * @return ActionResultInterface<DealInfo>
         */
        public function getAllDeals(string $position_id): ActionResultInterface;

    #endregion
    
    #region Order execution

        /**
         * @param string $login
         * @param string[] $order_ids
         * @return ActionResultInterface<null>
         */
        public function cancelOrders(string $login, array $order_ids): ActionResultInterface;

        /**
         * @return ActionResultInterface<Order[]>
         */
        public function getOrdersByTickets(string $order_id, string ...$order_ids): ActionResultInterface;

        /**
         * @param GetOrdersCommand $command
         * @return ActionResultInterface<Order[]>
         */
        public function getOrders(CommandInterface $command): ActionResultInterface;

        /**
         * @return ActionResultInterface<Order>
         */
        public function getOrder(string $order_id): ActionResultInterface;

    #endregion

    #region Deals

        /**
         * @param GetDealsHistoryCommand $command
         * @return ActionResultInterface<DealInfo[]>
         */
        public function getDealsHistory(CommandInterface $command): ActionResultInterface;

        /**
         * @return ActionResultInterface<DealInfo>
         */
        public function getDeal(string $deal_id): ActionResultInterface;

        /**
         * @return ActionResultInterface<DealInfo>
         */
        public function getOpenDeal(string $position_id): ActionResultInterface;

        /**
         * @return ActionResultInterface<DealInfo>
         */
        public function getCloseDeal(string $position_id): ActionResultInterface;

    #endregion

    #region Market data and Symbols

        /**
         * @return ActionResultInterface<SymbolInfo[]>
         */
        public function getSymbols(?string $group_filter = null): ActionResultInterface;

        /**
         * @return ActionResultInterface<SymbolInfo>
         */
        public function getSymbol(string $symbol_name): ActionResultInterface;

        /**
         * @return ActionResultInterface<string[]>
         */
        public function getSymbolCategories(): ActionResultInterface;

        /** @todo Pendiente la revision del contrato e implementacion */
        public function marketCategoryTree(): ActionResultInterface;

        /**
         * @return ActionResultInterface<TickInfo>
         */
        public function getLastTick(string $symbol_name): ActionResultInterface;

        /**
         * @return ActionResultInterface<TickInfo>
         */
        public function getTickAt(string $symbol_name, int $timestamp): ActionResultInterface;

        /**
         * @param GetTickRangeCommand $command
         * @return ActionResultInterface<TickInfo[]>
         */
        public function getTickRange(string $symbolName, CommandInterface $command): ActionResultInterface;

    #endregion

    #region Groups

        /**
         * @param GetGroupsCommand $command
         * @return ActionResultInterface<GroupsResponse>
         */
        public function getGroups(CommandInterface $command): ActionResultInterface;

        /**
         * @return ActionResultInterface<GroupInfo>
         */
        public function getGroup(string $groupName, ?string $user_id = null): ActionResultInterface;

    #endregion

    #region General Ops
        
        /**
         * @return ActionResultInterface<LeverageProfile[]>
         */
        public function getLeverageProfiles(int $limit, int $offset): ActionResultInterface;

        /**
         *  @return ActionResultInterface<Asset[]>
         */
        public function listAssets(?int $offset = null): ActionResultInterface;

        /**
         * @return ActionResultInterface<RoleInfo[]>
         */
        public function getRoles(): ActionResultInterface;

    #endregion
}