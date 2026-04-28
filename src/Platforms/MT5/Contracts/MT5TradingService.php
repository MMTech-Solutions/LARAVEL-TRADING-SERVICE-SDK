<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Contracts;

use Mmt\TradingServiceSdk\Platforms\MT5\Commands\{
    ChangePasswordCommand, CheckPasswordCommand, CloseAllPositionsCommand, ClosePositionCommand, CreateUserCommand,
    GetDealsHistoryCommand, GetMarginLevelCommand, GetMarginLevelsCommand, GetOrdersByTicketsCommand, GetOrdersCommand,
    GetPriceHistoryCommand, ListSymbolsCommand, ModifyPositionCommand, OpenPositionCommand, SetUserAccessCommand, TransactionCommand, UpdateUserCommand
};
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\{
    ActionResultInterface, TransportInterface, TransportPacket
};
use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses\MarginLevelItem;
use InvalidArgumentException;

class MT5TradingService implements MT5TradingServiceInterface
{
    private const TIMEOUT_EXECUTE_POSITION = 70.0;

    private const TIMEOUT_CLOSE_ALL_POSITIONS = 125.0;

    private const TIMEOUT_GET_POSITIONS = 35.0;

    private string $url = '/v1/mt5/connections';

    public function __construct(
        private readonly string $connectionId,
        private readonly TransportInterface $transport
    ) {}

    public function getGroupHierarchy(): ActionResultInterface
    {
        return $this->sendPacket('get', $this->url.'/'.$this->connectionId.'/groups/hierarchy');
    }

    /**
     * @param ?ListSymbolsCommand $command
     * @return ActionResultInterface<string[]>
     */
    public function getSymbolCategories(?CommandInterface $command = null): ActionResultInterface
    {
        $url = $this->url.'/'.$this->connectionId.'/symbol-categories';

        return $this->sendPacket('get', $url, $command?->toArray() ?? []);
    }

    public function listGroups(): ActionResultInterface
    {
        $url = $this->url.'/'.$this->connectionId.'/groups';

        return $this->sendPacket('get', $url);
    }

    public function getGroup(string $name): ActionResultInterface
    {
        $url = $this->url.'/'.$this->connectionId.'/groups/'.$this->encodePathSegment($name);

        return $this->sendPacket('get', $url);
    }

    public function listSymbols(?CommandInterface $command = null): ActionResultInterface
    {
        return $this->sendPacket('get', $this->url.'/'.$this->connectionId.'/symbols', $command?->toArray() ?? []);
    }

    public function getSymbol(string $name): ActionResultInterface
    {
        $url = $this->url.'/'.$this->connectionId.'/symbols/'.$this->encodePathSegment($name);

        return $this->sendPacket('get', $url);
    }

    public function getLastPrice(string $name): ActionResultInterface
    {
        $url = $this->url.'/'.$this->connectionId.'/symbols/'.$this->encodePathSegment($name).'/last-price';

        return $this->sendPacket('get', $url);
    }

    public function getPriceAt(string $name, int $timestamp): ActionResultInterface
    {
        $url = $this->url.'/'.$this->connectionId.'/symbols/'.$this->encodePathSegment($name).'/price-at';

        return $this->sendPacket('get', $url, ['timestamp' => $timestamp]);
    }

    public function getPriceHistory(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof GetPriceHistoryCommand) {
            throw new InvalidArgumentException('Expected '.GetPriceHistoryCommand::class);
        }

        $url = $this->url.'/'.$this->connectionId.'/symbols/'.$this->encodePathSegment($command->name).'/price-history';

        return $this->sendPacket('get', $url, $command->toArray());
    }

    public function createUser(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof CreateUserCommand) {
            throw new InvalidArgumentException('Expected '.CreateUserCommand::class);
        }

        return $this->sendPacket('post', $this->url.'/'.$this->connectionId.'/users', $command->toArray(), ['timeout' => 60]);
    }

    public function getServerTime(): ActionResultInterface
    {
        return $this->sendPacket('get', $this->url.'/'.$this->connectionId.'/server-time');
    }

    public function getAllPositions(): ActionResultInterface
    {
        return $this->sendPacket('get', $this->url.'/'.$this->connectionId.'/positions/all');
    }

    public function openPosition(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof OpenPositionCommand) {
            throw new InvalidArgumentException('Expected '.OpenPositionCommand::class);
        }

        return $this->sendPacket(
            'post',
            $this->url.'/'.$this->connectionId.'/positions/execute',
            $command->toArray(),
            ['timeout' => self::TIMEOUT_EXECUTE_POSITION]
        );
    }

    public function modifyPosition(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof ModifyPositionCommand) {
            throw new InvalidArgumentException('Expected '.ModifyPositionCommand::class);
        }

        return $this->sendPacket('patch', $this->url.'/'.$this->connectionId.'/positions', $command->toArray());
    }

    public function closePosition(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof ClosePositionCommand) {
            throw new InvalidArgumentException('Expected '.ClosePositionCommand::class);
        }

        return $this->sendPacket('post', $this->url.'/'.$this->connectionId.'/positions/close', $command->toArray());
    }

    public function closeAllPositions(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof CloseAllPositionsCommand) {
            throw new InvalidArgumentException('Expected '.CloseAllPositionsCommand::class);
        }

        return $this->sendPacket(
            'post',
            $this->url.'/'.$this->connectionId.'/positions/close-all',
            $command->toArray(),
            ['timeout' => self::TIMEOUT_CLOSE_ALL_POSITIONS]
        );
    }

    public function getPositions(string $login): ActionResultInterface
    {
        return $this->sendPacket(
            'get',
            $this->url.'/'.$this->connectionId.'/positions',
            ['login' => $login],
            ['timeout' => self::TIMEOUT_GET_POSITIONS]
        );
    }

    public function getPosition(string $entityId): ActionResultInterface
    {
        $url = $this->url.'/'.$this->connectionId.'/positions/'.$this->encodePathSegment($entityId);

        return $this->sendPacket('get', $url);
    }

    public function getDeal(string $dealId): ActionResultInterface
    {
        $url = $this->url.'/'.$this->connectionId.'/deals/'.$this->encodePathSegment($dealId);

        return $this->sendPacket('get', $url);
    }

    public function getOpenDeal(string $positionId): ActionResultInterface
    {
        $url = $this->url.'/'.$this->connectionId.'/deals/open/'.$this->encodePathSegment($positionId);

        return $this->sendPacket('get', $url);
    }

    public function getCloseDeal(string $positionId): ActionResultInterface
    {
        $url = $this->url.'/'.$this->connectionId.'/deals/close/'.$this->encodePathSegment($positionId);

        return $this->sendPacket('get', $url);
    }

    public function getAllDealsForPosition(string $positionId): ActionResultInterface
    {
        $url = $this->url.'/'.$this->connectionId.'/deals/position/'.$this->encodePathSegment($positionId);

        return $this->sendPacket('get', $url);
    }

    public function getDealsHistory(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof GetDealsHistoryCommand) {
            throw new InvalidArgumentException('Expected '.GetDealsHistoryCommand::class);
        }

        return $this->sendPacket('get', $this->url.'/'.$this->connectionId.'/deals/history', $command->toArray());
    }

    public function getOrder(string $orderId): ActionResultInterface
    {
        $url = $this->url.'/'.$this->connectionId.'/orders/'.$this->encodePathSegment($orderId);

        return $this->sendPacket('get', $url);
    }

    public function getOrdersByTickets(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof GetOrdersByTicketsCommand) {
            throw new InvalidArgumentException('Expected '.GetOrdersByTicketsCommand::class);
        }

        return $this->sendPacket('get', $this->url.'/'.$this->connectionId.'/orders/by-tickets', $command->toArray());
    }

    public function getOrders(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof GetOrdersCommand) {
            throw new InvalidArgumentException('Expected '.GetOrdersCommand::class);
        }

        return $this->sendPacket('get', $this->url.'/'.$this->connectionId.'/orders', $command->toArray());
    }

    public function listUsers(?CommandInterface $command = null): ActionResultInterface
    {
        return $this->sendPacket('get', $this->url.'/'.$this->connectionId.'/users', $command?->toArray() ?? []);
    }

    /**
     * @param GetMarginLevelCommand $command
     * @return ActionResultInterface<MarginLevelItem>
     */
    public function getMarginLevel(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof GetMarginLevelCommand) {
            throw new InvalidArgumentException('Expected '.GetMarginLevelCommand::class);
        }

        $login = $this->encodePathSegment($command->login);
        $url = $this->url.'/'.$this->connectionId.'/users/'.$login.'/margin';

        return $this->sendPacket('get', $url, $command->toArray());
    }

    public function getUser(string $login): ActionResultInterface
    {
        $url = $this->url.'/'.$this->connectionId.'/users/'.$this->encodePathSegment($login);

        return $this->sendPacket('get', $url);
    }

    public function updateUser(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof UpdateUserCommand) {
            throw new InvalidArgumentException('Expected '.UpdateUserCommand::class);
        }

        return $this->sendPacket('patch', $this->url.'/'.$this->connectionId.'/users', $command->toArray());
    }

    public function changePassword(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof ChangePasswordCommand) {
            throw new InvalidArgumentException('Expected '.ChangePasswordCommand::class);
        }

        return $this->sendPacket('post', $this->url.'/'.$this->connectionId.'/users/change-password', $command->toArray());
    }

    public function checkPassword(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof CheckPasswordCommand) {
            throw new InvalidArgumentException('Expected '.CheckPasswordCommand::class);
        }

        return $this->sendPacket('post', $this->url.'/'.$this->connectionId.'/users/check-password', $command->toArray());
    }

    public function getMarginLevels(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof GetMarginLevelsCommand) {
            throw new InvalidArgumentException('Expected '.GetMarginLevelsCommand::class);
        }

        return $this->sendPacket('get', $this->url.'/'.$this->connectionId.'/users/margins', ['logins' => $command->toArray()]);
    }

    public function getMarginLevelsByOpenPositions(): ActionResultInterface
    {
        return $this->sendPacket('get', $this->url.'/'.$this->connectionId.'/users/margins-by-open-positions');
    }

    public function getAccountState(string $login): ActionResultInterface
    {
        $url = $this->url.'/'.$this->connectionId.'/users/'.$this->encodePathSegment($login).'/account-state';

        return $this->sendPacket('get', $url);
    }

    public function setUserAccess(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof SetUserAccessCommand) {
            throw new InvalidArgumentException('Expected '.SetUserAccessCommand::class);
        }

        return $this->sendPacket('post', $this->url.'/'.$this->connectionId.'/users/access', $command->toArray());
    }

    public function changeBalance(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof TransactionCommand) {
            throw new InvalidArgumentException('Expected '.TransactionCommand::class);
        }

        return $this->sendPacket('post', $this->url.'/'.$this->connectionId.'/transactions/change', $command->toArray());
    }

    public function setBalance(CommandInterface $command): ActionResultInterface
    {
        if (! $command instanceof TransactionCommand) {
            throw new InvalidArgumentException('Expected '.TransactionCommand::class);
        }

        return $this->sendPacket('post', $this->url.'/'.$this->connectionId.'/transactions/set', $command->toArray());
    }

    private function encodePathSegment(string $value): string
    {
        return rawurlencode($value);
    }

    /**
     * @param array<string, mixed> $metadata
     */
    private function sendPacket(string $method, string $url, array $payload = [], array $metadata = []): ActionResultInterface
    {
        $packet = new TransportPacket(
            endpoint: $url,
            payload: $payload,
            metadata: array_merge(['method' => $method], $metadata),
        );

        return $this->transport->send($packet);
    }
}
