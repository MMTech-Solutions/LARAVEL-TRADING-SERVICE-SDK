<?php

namespace Mmt\TradingServiceSdk\Platforms\Shared\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Mmt\TradingServiceSdk\Enums\PlatformEnum;

/**
 * Broker connect command.
 *
 * The platform is sent as a URL path segment (POST /v1/admin/brokers/connect/{platform}),
 * not in the request body.
 */
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
            keycloak_url: $data['keycloak_url'] ?? null,
            bbp_client_id: $data['bbp_client_id'] ?? null,
            bbp_client_secret: $data['bbp_client_secret'] ?? null,
        );
    }

    /**
     * Returns the platform slug used in the connect URL path (e.g. "mt5").
     */
    public function platformSlug(): string
    {
        return strtolower($this->platform_type->name);
    }

    /**
     * Body payload — platform_type is NOT included; it goes in the URL path.
     */
    public function toArray(): array
    {
        $payload = [
            'server' => $this->server,
            'port' => $this->port,
            'login' => $this->login,
            'password' => $this->password,
            'name' => $this->name,
            'keycloak_url' => $this->keycloak_url,
            'bbp_client_id' => $this->bbp_client_id,
            'bbp_client_secret' => $this->bbp_client_secret,
        ];

        return array_filter($payload, fn ($v) => ! is_null($v));
    }
}