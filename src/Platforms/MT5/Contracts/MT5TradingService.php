<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Contracts;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\ChangePasswordCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\CheckPasswordCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\CreateUserCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\GetMarginLevelCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\GetMarginLevelsCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\GetPriceHistoryCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\ListSymbolsCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\SetUserAccessCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\UpdateUserCommand;
use Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses\MarginLevelItem;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\ResponseResult;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\TransportInterface;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\TransportPacket;
use InvalidArgumentException;

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

    public function getGroup(string $name): ResponseResult
    {
        $url = $this->url.'/'.$this->connectionId.'/groups/'.$this->encodePathSegment($name);

        return $this->sendPacket('get', $url);
    }

    public function listSymbols(?CommandInterface $command = null): ResponseResult
    {
        return $this->sendPacket('get', $this->url.'/'.$this->connectionId.'/symbols', $command?->toArray() ?? []);
    }

    public function getSymbol(string $name): ResponseResult
    {
        $url = $this->url.'/'.$this->connectionId.'/symbols/'.$this->encodePathSegment($name);

        return $this->sendPacket('get', $url);
    }

    public function getLastPrice(string $name): ResponseResult
    {
        $url = $this->url.'/'.$this->connectionId.'/symbols/'.$this->encodePathSegment($name).'/last-price';

        return $this->sendPacket('get', $url);
    }

    public function getPriceAt(string $name, int $timestamp): ResponseResult
    {
        $url = $this->url.'/'.$this->connectionId.'/symbols/'.$this->encodePathSegment($name).'/price-at';

        return $this->sendPacket('get', $url, ['timestamp' => $timestamp]);
    }

    public function getPriceHistory(CommandInterface $command): ResponseResult
    {
        if (! $command instanceof GetPriceHistoryCommand) {
            throw new InvalidArgumentException('Expected '.GetPriceHistoryCommand::class);
        }

        $url = $this->url.'/'.$this->connectionId.'/symbols/'.$this->encodePathSegment($command->name).'/price-history';

        return $this->sendPacket('get', $url, $command->toArray());
    }

    public function createUser(CommandInterface $command): ResponseResult
    {
        if (! $command instanceof CreateUserCommand) {
            throw new InvalidArgumentException('Expected '.CreateUserCommand::class);
        }

        return $this->sendPacket('post', $this->url.'/'.$this->connectionId.'/users', $command->toArray());
    }

    public function getServerTime(): ResponseResult
    {
        return $this->sendPacket('get', $this->url.'/'.$this->connectionId.'/server-time');
    }

    public function getAllPositions(): ResponseResult
    {
        return $this->sendPacket('get', $this->url.'/'.$this->connectionId.'/positions/all');
    }

    public function listUsers(?CommandInterface $command = null): ResponseResult
    {
        return $this->sendPacket('get', $this->url.'/'.$this->connectionId.'/users', $command?->toArray() ?? []);
    }

    /**
     * @param GetMarginLevelCommand $command
     * @return ResponseResult<MarginLevelItem>
     */
    public function getMarginLevel(CommandInterface $command): ResponseResult
    {
        if (! $command instanceof GetMarginLevelCommand) {
            throw new InvalidArgumentException('Expected '.GetMarginLevelCommand::class);
        }

        $login = $this->encodePathSegment($command->login);
        $url = $this->url.'/'.$this->connectionId.'/users/'.$login.'/margin';

        return $this->sendPacket('get', $url, $command->toArray());
    }

    public function getUser(string $login): ResponseResult
    {
        $url = $this->url.'/'.$this->connectionId.'/users/'.$this->encodePathSegment($login);

        return $this->sendPacket('get', $url);
    }

    public function updateUser(CommandInterface $command): ResponseResult
    {
        if (! $command instanceof UpdateUserCommand) {
            throw new InvalidArgumentException('Expected '.UpdateUserCommand::class);
        }

        return $this->sendPacket('patch', $this->url.'/'.$this->connectionId.'/users', $command->toArray());
    }

    public function changePassword(CommandInterface $command): ResponseResult
    {
        if (! $command instanceof ChangePasswordCommand) {
            throw new InvalidArgumentException('Expected '.ChangePasswordCommand::class);
        }

        return $this->sendPacket('post', $this->url.'/'.$this->connectionId.'/users/change-password', $command->toArray());
    }

    public function checkPassword(CommandInterface $command): ResponseResult
    {
        if (! $command instanceof CheckPasswordCommand) {
            throw new InvalidArgumentException('Expected '.CheckPasswordCommand::class);
        }

        return $this->sendPacket('post', $this->url.'/'.$this->connectionId.'/users/check-password', $command->toArray());
    }

    public function getMarginLevels(CommandInterface $command): ResponseResult
    {
        if (! $command instanceof GetMarginLevelsCommand) {
            throw new InvalidArgumentException('Expected '.GetMarginLevelsCommand::class);
        }

        return $this->sendPacket('post', $this->url.'/'.$this->connectionId.'/users/margins', $command->toArray());
    }

    public function getMarginLevelsByOpenPositions(): ResponseResult
    {
        return $this->sendPacket('get', $this->url.'/'.$this->connectionId.'/users/margins-by-open-positions');
    }

    public function getAccountState(string $login): ResponseResult
    {
        $url = $this->url.'/'.$this->connectionId.'/users/'.$this->encodePathSegment($login).'/account-state';

        return $this->sendPacket('get', $url);
    }

    public function setUserAccess(CommandInterface $command): ResponseResult
    {
        if (! $command instanceof SetUserAccessCommand) {
            throw new InvalidArgumentException('Expected '.SetUserAccessCommand::class);
        }

        return $this->sendPacket('post', $this->url.'/'.$this->connectionId.'/users/access', $command->toArray());
    }

    private function encodePathSegment(string $value): string
    {
        return rawurlencode($value);
    }

    /**
     * @param array<string, mixed> $metadata
     */
    private function sendPacket(string $method, string $url, array $payload = [], array $metadata = []): ResponseResult
    {
        $packet = new TransportPacket(
            endpoint: $url,
            payload: $payload,
            metadata: array_merge(['method' => $method], $metadata),
        );

        return $this->transport->send($packet);
    }
}
