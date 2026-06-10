<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Commands;

use Mmt\TradingServiceSdk\Contracts\ConnectCommandInterface;
use Override;

/**
 * Broker connect command for B2Trader (B2Broker / BBP).
 *
 * The platform is sent as a URL path segment (POST /v1/admin/brokers/connect/b2t),
 * not in the request body.
 */
class B2TConnectCommand implements ConnectCommandInterface
{
    public function __construct(
        public readonly string $server,
        public readonly int $port,
        public readonly string $login,
        public readonly string $password,
        public readonly string $name,
        public readonly string $keycloak_url,
        public readonly string $bbp_client_id,
        public readonly string $bbp_client_secret,
        public readonly string $history_base_url,
        public readonly string $default_transfer_asset_id,
        public readonly string $dss_ws_base_url,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            server: $data['server'],
            port: (int) $data['port'],
            login: $data['login'],
            password: $data['password'],
            name: $data['name'],
            keycloak_url: $data['keycloak_url'],
            bbp_client_id: $data['bbp_client_id'],
            bbp_client_secret: $data['bbp_client_secret'],
            history_base_url: $data['history_base_url'],
            default_transfer_asset_id: $data['default_transfer_asset_id'],
            dss_ws_base_url: $data['dss_ws_base_url'],
        );
    }

    #[Override]
    public function toArray(): array
    {
        return [
            'server' => $this->server,
            'port' => $this->port,
            'login' => $this->login,
            'password' => $this->password,
            'name' => $this->name,
            'keycloak_url' => $this->keycloak_url,
            'bbp_client_id' => $this->bbp_client_id,
            'bbp_client_secret' => $this->bbp_client_secret,
            'history_base_url' => $this->history_base_url,
            'default_transfer_asset_id' => $this->default_transfer_asset_id,
            'dss_ws_base_url' => $this->dss_ws_base_url,
        ];
    }

    #[Override]
    public function platformSlug(): string
    {
        return 'b2t';
    }
}
