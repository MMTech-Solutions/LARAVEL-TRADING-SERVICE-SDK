<?php

declare(strict_types=1);

namespace Mmt\TradingServiceSdk\Platforms\CTrader\Contracts;

use InvalidArgumentException;
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
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\ActionResultInterface;
use Mmt\TradingServiceSdk\TransportDrivers\Traits\WithHttpClient;
use Override;

class CTraderTradingService implements CTraderTradingServiceInterface
{
    use WithHttpClient;

    private const TIMEOUT_EXECUTE_POSITION = 70.0;

    private const TIMEOUT_CLOSE_ALL_POSITIONS = 125.0;

    private const TIMEOUT_GET_POSITIONS = 35.0;

    public function __construct(private readonly string $connectionId)
    {
        $this->setBaseUrl("/v1/ctrader/connections/{$this->connectionId}");
    }

    // -------------------------------------------------------------------------
    // Server
    // -------------------------------------------------------------------------

    #[Override]
    public function getServerTime(): ActionResultInterface
    {
        return $this->get('server-time');
    }

    // -------------------------------------------------------------------------
    // Users
    // -------------------------------------------------------------------------

    #[Override]
    public function listUsers(?string $groupFilter = null): ActionResultInterface
    {
        $payload = array_filter(['group_filter' => $groupFilter], fn ($v) => $v !== null);

        return $this->get('users', $payload);
    }

    #[Override]
    public function getUser(string $login): ActionResultInterface
    {
        return $this->get('users/'.$this->encodePathSegment($login));
    }

    #[Override]
    public function createUser(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof CreateUserCommand) {
            throw new InvalidArgumentException('Expected '.CreateUserCommand::class);
        }

        return $this->post('users', $command->toArray());
    }

    #[Override]
    public function updateUser(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof UpdateUserCommand) {
            throw new InvalidArgumentException('Expected '.UpdateUserCommand::class);
        }

        return $this->patch('users', $command->toArray());
    }

    #[Override]
    public function getAccountState(string $login): ActionResultInterface
    {
        return $this->get('users/'.$this->encodePathSegment($login).'/account-state');
    }

    #[Override]
    public function setUserAccess(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof SetUserAccessCommand) {
            throw new InvalidArgumentException('Expected '.SetUserAccessCommand::class);
        }

        return $this->post('users/access', $command->toArray());
    }

    #[Override]
    public function changePassword(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof ChangePasswordCommand) {
            throw new InvalidArgumentException('Expected '.ChangePasswordCommand::class);
        }

        return $this->post('users/change-password', $command->toArray());
    }

    #[Override]
    public function checkPassword(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof CheckPasswordCommand) {
            throw new InvalidArgumentException('Expected '.CheckPasswordCommand::class);
        }

        return $this->post('users/check-password', $command->toArray());
    }

    #[Override]
    public function getMarginLevel(string $login): ActionResultInterface
    {
        return $this->get('users/'.$this->encodePathSegment($login).'/margin');
    }

    #[Override]
    public function getMarginLevels(CommandInterface $command): ActionResultInterface
    {
        return $this->get('users/margins', $command->toArray());
    }

    #[Override]
    public function getMarginLevelsByOpenPositions(): ActionResultInterface
    {
        return $this->get('users/margins-by-open-positions');
    }

    // -------------------------------------------------------------------------
    // Transactions
    // -------------------------------------------------------------------------

    #[Override]
    public function changeBalance(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof TransactionCommand) {
            throw new InvalidArgumentException('Expected '.TransactionCommand::class);
        }

        return $this->post('transactions/change', $command->toArray());
    }

    #[Override]
    public function setBalance(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof TransactionCommand) {
            throw new InvalidArgumentException('Expected '.TransactionCommand::class);
        }

        return $this->post('transactions/set', $command->toArray());
    }

    // -------------------------------------------------------------------------
    // Groups
    // -------------------------------------------------------------------------

    #[Override]
    public function listGroups(): ActionResultInterface
    {
        return $this->get('groups');
    }

    #[Override]
    public function getGroupHierarchy(): ActionResultInterface
    {
        return $this->get('groups/hierarchy');
    }

    #[Override]
    public function getGroup(string $name): ActionResultInterface
    {
        return $this->get('groups/'.$this->encodePathSegment($name));
    }

    // -------------------------------------------------------------------------
    // Symbols
    // -------------------------------------------------------------------------

    #[Override]
    public function listSymbols(?string $groupFilter = null): ActionResultInterface
    {
        $payload = array_filter(['group_filter' => $groupFilter], fn ($v) => $v !== null);

        return $this->get('symbols', $payload);
    }

    #[Override]
    public function getSymbol(string $name): ActionResultInterface
    {
        return $this->get('symbols/'.$this->encodePathSegment($name));
    }

    #[Override]
    public function getSymbolCategories(): ActionResultInterface
    {
        return $this->get('symbol-categories');
    }

    #[Override]
    public function getLastPrice(string $name): ActionResultInterface
    {
        return $this->get('symbols/'.$this->encodePathSegment($name).'/last-price');
    }

    #[Override]
    public function getPriceAt(string $name, int $timestamp): ActionResultInterface
    {
        return $this->get('symbols/'.$this->encodePathSegment($name).'/price-at', ['timestamp' => $timestamp]);
    }

    #[Override]
    public function getPriceHistory(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof GetPriceHistoryCommand) {
            throw new InvalidArgumentException('Expected '.GetPriceHistoryCommand::class);
        }

        return $this->get('symbols/'.$this->encodePathSegment($command->name).'/price-history', $command->toArray());
    }

    // -------------------------------------------------------------------------
    // Positions
    // -------------------------------------------------------------------------

    #[Override]
    public function getAllPositions(): ActionResultInterface
    {
        return $this->get('positions/all');
    }

    #[Override]
    public function getPositions(string $login): ActionResultInterface
    {
        return $this->get('positions', ['login' => $login], ['timeout' => self::TIMEOUT_GET_POSITIONS]);
    }

    #[Override]
    public function getPosition(string $entityId): ActionResultInterface
    {
        return $this->get('positions/'.$this->encodePathSegment($entityId));
    }

    #[Override]
    public function openPosition(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof OpenPositionCommand) {
            throw new InvalidArgumentException('Expected '.OpenPositionCommand::class);
        }

        return $this->post('positions/execute', $command->toArray(), ['timeout' => self::TIMEOUT_EXECUTE_POSITION]);
    }

    #[Override]
    public function modifyPosition(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof ModifyPositionCommand) {
            throw new InvalidArgumentException('Expected '.ModifyPositionCommand::class);
        }

        return $this->patch('positions', $command->toArray());
    }

    #[Override]
    public function closePosition(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof ClosePositionCommand) {
            throw new InvalidArgumentException('Expected '.ClosePositionCommand::class);
        }

        return $this->post('positions/close', $command->toArray());
    }

    #[Override]
    public function closeAllPositions(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof CloseAllPositionsCommand) {
            throw new InvalidArgumentException('Expected '.CloseAllPositionsCommand::class);
        }

        return $this->post('positions/close-all', $command->toArray(), ['timeout' => self::TIMEOUT_CLOSE_ALL_POSITIONS]);
    }

    #[Override]
    public function getClosedPositions(?CommandInterface $command = null): ActionResultInterface
    {
        return $this->get('positions/closed', $command?->toArray() ?? []);
    }

    // -------------------------------------------------------------------------
    // Deals
    // -------------------------------------------------------------------------

    #[Override]
    public function getDeal(string $dealId): ActionResultInterface
    {
        return $this->get('deals/'.$this->encodePathSegment($dealId));
    }

    #[Override]
    public function getOpenDeal(string $positionId): ActionResultInterface
    {
        return $this->get('deals/open/'.$this->encodePathSegment($positionId));
    }

    #[Override]
    public function getCloseDeal(string $positionId): ActionResultInterface
    {
        return $this->get('deals/close/'.$this->encodePathSegment($positionId));
    }

    #[Override]
    public function getAllDealsForPosition(string $positionId): ActionResultInterface
    {
        return $this->get('deals/position/'.$this->encodePathSegment($positionId));
    }

    #[Override]
    public function getDealsHistory(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof GetDealsHistoryCommand) {
            throw new InvalidArgumentException('Expected '.GetDealsHistoryCommand::class);
        }

        return $this->get('deals/history', $command->toArray());
    }

    // -------------------------------------------------------------------------
    // Orders
    // -------------------------------------------------------------------------

    #[Override]
    public function getOrder(string $orderId): ActionResultInterface
    {
        return $this->get('orders/'.$this->encodePathSegment($orderId));
    }

    #[Override]
    public function getOrders(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof GetOrdersCommand) {
            throw new InvalidArgumentException('Expected '.GetOrdersCommand::class);
        }

        return $this->get('orders', $command->toArray());
    }

    #[Override]
    public function getOrdersByTickets(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof GetOrdersByTicketsCommand) {
            throw new InvalidArgumentException('Expected '.GetOrdersByTicketsCommand::class);
        }

        return $this->get('orders/by-tickets', $command->toArray());
    }

    #[Override]
    public function cancelAllOpenOrders(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof CancelAllOpenOrdersCommand) {
            throw new InvalidArgumentException('Expected '.CancelAllOpenOrdersCommand::class);
        }

        return $this->post('orders/cancel-all', $command->toArray(), ['timeout' => 65.0]);
    }

    // -------------------------------------------------------------------------
    // Trading
    // -------------------------------------------------------------------------

    #[Override]
    public function closeAllTrading(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof CloseAllTradingCommand) {
            throw new InvalidArgumentException('Expected '.CloseAllTradingCommand::class);
        }

        return $this->post('trading/close-all', $command->toArray(), ['timeout' => self::TIMEOUT_CLOSE_ALL_POSITIONS]);
    }
}
