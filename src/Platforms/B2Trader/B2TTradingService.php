<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Mmt\TradingServiceSdk\Enums\PlatformEnum;
use Mmt\TradingServiceSdk\Platforms\B2Trader\Contracts\B2TTradingServiceInterface;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\ActionResultInterface;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\TransportInterface;
use Mmt\TradingServiceSdk\TransportDrivers\Traits\WithHttpClient;
use Override;

class B2TTradingService implements B2TTradingServiceInterface
{
    use WithHttpClient;

    private const TIMEOUT_EXECUTE_POSITION = 70.0;

    private const TIMEOUT_CLOSE_ALL_POSITIONS = 125.0;

    private const TIMEOUT_GET_POSITIONS = 35.0;

    public function __construct(
        private readonly string $connectionId
    ) {
        $platform = PlatformEnum::B2T->toLowerCase();
        $this->setBaseUrl("/v1/{$platform}/connections/{$this->connectionId}");
    }
    
    #[Override]
    public function getServerTime(): ActionResultInterface
    {
        return $this->get('server-time');
    }

    #[Override]
    public function createUser(CommandInterface $command): ActionResultInterface
    {
        return $this->post('users', $command->toArray());
    }

    #[Override]
    public function listUsers(string $groupFilter): ActionResultInterface
    {
        return $this->get('users', ['group_filter' => $groupFilter]);
    }

    #[Override]
    public function changePassword(CommandInterface $command): ActionResultInterface
    {
        return $this->post('users/change-password', $command->toArray());
    }

    #[Override]
    public function setUserAccess(string $login, string $access): ActionResultInterface
    {
        return $this->post('users/access', ['login' => $login, 'access' => $access]);
    }

    #[Override]
    public function getUsersByIds(string $user_id, string ...$user_ids): ActionResultInterface
    {
        $userIds = array_merge([$user_id], $user_ids);
        return $this->get('users/query', ['user_ids' => $userIds]);
    }

    #[Override]
    public function getUser(string $user_id): ActionResultInterface
    {
        return $this->get("users/profile/$user_id");
    }

    #[Override]
    public function getUserByLogin(string $login): ActionResultInterface
    {
        return $this->get("users/by-login/$login");
    }

    #[Override]
    public function getUserAccess(string $user_id): ActionResultInterface
    {
        return $this->get("users/{$user_id}/access");
    }

    #[Override]
    public function getAccountState(string $login): ActionResultInterface
    {
        return $this->get("users/{$login}/account-state");
    }

    #[Override]
    public function getMarginLevel(string $login): ActionResultInterface
    {
        return $this->get("users/{$login}/margin");
    }

    #[Override]
    public function getMarginLevels(string $login, string ...$logins): ActionResultInterface
    {
        $_logins = array_merge([$login], $logins);
        return $this->get("users/margins", $_logins);
    }

    #[Override]
    public function getMarginLevelsWithOpenPositions(): ActionResultInterface
    {
        return $this->get("users/margins-by-open-positions");
    }

    #[Override]
    public function createAccount(string $userId, CommandInterface $command): ActionResultInterface
    {
        return $this->post("users/{$userId}/accounts", $command->toArray());
    }

    #[Override]
    public function getAccountsByUserId(string $user_id): ActionResultInterface
    {
        return $this->get("users/{$user_id}/accounts");
    }

    #[Override]
    public function getAccount(string $login): ActionResultInterface
    {
        return $this->get("accounts/{$login}");
    }

    #[Override]
    public function getAccounts(string $login, string ...$logins): ActionResultInterface
    {
        $_logins = array_merge([$login], $logins);
        return $this->get("accounts/query", $_logins);
    }

    #[Override]
    public function getAccountsByUserIds(string $user_id, string ...$user_ids): ActionResultInterface
    {
        $_userIds = array_merge([$user_id], $user_ids);
        return $this->get("users/accounts/query", $_userIds);
    }

    #[Override]
    public function closePositionsAndCancelOpenOrders(string $login, ?string $symbolFilter = null): ActionResultInterface
    {
        return $this->post("trading/close-all", ['login' => $login, 'symbol_filter' => $symbolFilter]);
    }

    #[Override]
    public function getAccountTransfersHistory(string $login, CommandInterface $command): ActionResultInterface
    {
        return $this->get("users/{$login}/transfers", $command->toArray());
    }

    #[Override]
    public function addBalance(CommandInterface $command): ActionResultInterface
    {
        return $this->post("transactions/change", $command->toArray());
    }

    #[Override]
    public function setBalance(CommandInterface $command): ActionResultInterface
    {
        return $this->post("transactions/set", $command->toArray());
    }

    #[Override]
    public function getTransactionDetails(string $transaction_id): ActionResultInterface
    {
        return $this->get("transfers/{$transaction_id}");
    }

    #[Override]
    public function getAllPositions(): ActionResultInterface
    {
        return $this->get('positions/all');
    }

    #[Override]
    public function getClosedPositions(string $login, ?CommandInterface $command = null): ActionResultInterface
    {
        return $this->get("positions/closed", ['login' => $login, 'command' => $command?->toArray() ?? []]);
    }

    public function getPositions(string $login): ActionResultInterface
    {
        return $this->get("positions", ['login' => $login]);
    }

    #[Override]
    public function updatePosition(CommandInterface $command): ActionResultInterface
    {
        return $this->patch('positions', $command->toArray());
    }

    #[Override]
    public function openPosition(CommandInterface $command): ActionResultInterface
    {
        return $this->post("positions/execute", $command->toArray());
    }

    #[Override]
    public function closePosition(CommandInterface $command): ActionResultInterface
    {
        return $this->post('positions/close', $command->toArray());
    }

    #[Override]
    public function closeAllPositions(string $login, ?string $symbol_filter = null): ActionResultInterface
    {
        return $this->post('positions/close-all', ['login' => $login, 'symbol_filter' => $symbol_filter]);
    }

    #[Override]
    public function getPosition(string $entity_id): ActionResultInterface
    {
        return $this->get("positions/{$entity_id}");
    }

    #[Override]
    public function getAllDeals(string $position_id): ActionResultInterface
    {
        return $this->get("deals/position/{$position_id}");
    }

    #[Override]
    public function cancelOrders(string $login, array $order_ids): ActionResultInterface
    {
        return $this->post('orders/cancel', ['login' => $login, 'order_ids' => $order_ids]);
    }

    #[Override]
    public function getOrdersByTickets(string $order_id, string ...$order_ids): ActionResultInterface
    {
        $_orderIds = array_merge([$order_id], $order_ids);
        return $this->get('orders/by-tickets', ['order_ids' => $_orderIds]);
    }

    #[Override]
    public function getOrders(CommandInterface $command): ActionResultInterface
    {
        return $this->get('orders', $command->toArray());
    }

    #[Override]
    public function getOrder(string $order_id): ActionResultInterface
    {
        return $this->get("orders/{$order_id}");
    }

    #[Override]
    public function getDealsHistory(CommandInterface $command): ActionResultInterface
    {
        return $this->get('deals/history', $command->toArray());
    }

    #[Override]
    public function getDeal(string $deal_id): ActionResultInterface
    {
        return $this->get("deals/{$deal_id}");
    }

    #[Override]
    public function getOpenDeal(string $position_id): ActionResultInterface
    {
        return $this->get("deals/open/{$position_id}");
    }

    #[Override]
    public function getCloseDeal(string $position_id): ActionResultInterface
    {
        return $this->get("deals/close/{$position_id}");
    }

    #[Override]
    public function getSymbols(?string $group_filter = null): ActionResultInterface
    {
        return $this->get('symbols', ['group_filter' => $group_filter]);
    }

    #[Override]
    public function getSymbol(string $symbol_name): ActionResultInterface
    {
        return $this->get("symbols/{$symbol_name}");
    }

    #[Override]
    public function getSymbolCategories(): ActionResultInterface
    {
        return $this->get('symbol-categories');
    }

    public function marketCategoryTree(): ActionResultInterface
    {
        return $this->get('markets-categories');
    }

    #[Override]
    public function getLastTick(string $symbol_name): ActionResultInterface
    {
        return $this->get("symbols/{$symbol_name}/last-price");
    }

    #[Override]
    public function getTickAt(string $symbol_name, int $timestamp): ActionResultInterface
    {
        return $this->get("symbols/{$symbol_name}/price-at", ['timestamp' => $timestamp]);
    }

    #[Override]
    public function getTickRange(string $symbolName, CommandInterface $command): ActionResultInterface
    {
        return $this->get("symbols/{$symbolName}/price-history", $command->toArray());
    }

    #[Override]
    public function getGroups(CommandInterface $command): ActionResultInterface
    {
        return $this->get("groups", $command->toArray());
    }

    #[Override]
    public function getGroup(string $group_name, ?string $user_id = null): ActionResultInterface
    {
        return $this->get("groups/{$group_name}", ['user_id' => $user_id]);
    }

    #[Override]
    public function getLeverageProfiles(int $limit, int $offset): ActionResultInterface
    {
        return $this->get('leverage-profiles', ['limit' => $limit, 'offset' => $offset]);
    }

    #[Override]
    public function listAssets(?int $offset = null): ActionResultInterface
    {
        return $this->get('assets');
    }

    #[Override]
    public function getRoles(): ActionResultInterface
    {
        return $this->get('roles');
    }
}