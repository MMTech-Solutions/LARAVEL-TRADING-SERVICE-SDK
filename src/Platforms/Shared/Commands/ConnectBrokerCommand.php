<?php

namespace Mmt\TradingServiceSdk\Platforms\Shared\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Mmt\TradingServiceSdk\Enums\PlatformEnum;

class ConnectBrokerCommand implements CommandInterface
{
    public function __construct(
        public readonly string $server,
        public readonly int $port,
        public readonly PlatformEnum $platform_type,
        public readonly string $login,
        public readonly string $password,
        public readonly string $name,
        public readonly ?string $keycloak_url = null,
        public readonly ?string $bbp_client_id = null,
        public readonly ?string $bbp_client_secret = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            server: $data['server'],
            port: $data['port'],
            platform_type: $data['platform_type'],
            login: $data['login'],
            password: $data['password'],
            name: $data['name'],
            keycloak_url: $data['keycloak_url'],
            bbp_client_id: $data['bbp_client_id'],
            bbp_client_secret: $data['bbp_client_secret'],
        );
    }

    public function toArray(): array
    {
        return [
            'server' => $this->server,
            'port' => $this->port,
            'platform_type' => $this->platform_type->name,
            'login' => $this->login,
            'password' => $this->password,
            'name' => $this->name,
            'keycloak_url' => $this->keycloak_url,
            'bbp_client_id' => $this->bbp_client_id,
            'bbp_client_secret' => $this->bbp_client_secret,
        ];
    }
}