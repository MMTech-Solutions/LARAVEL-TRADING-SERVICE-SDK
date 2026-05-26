<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Commands;

use Mmt\TradingServiceSdk\Contracts\ConnectCommandInterface;
use Override;

class B2TConnectCommand implements ConnectCommandInterface
{
    public function __construct(
        public readonly string $server,
        public readonly int $port,
        public readonly string $login,
        public readonly string $password,
        public readonly string $name,
        public readonly string $history_base_url,
        public readonly string $frontoffice_base_url,
        public readonly string $frontoffice_api_key,
        public readonly string $default_transfer_asset_id,
        public readonly string $kafka_bootstrap_servers,
        public readonly string $kafka_username,
        public readonly string $kafka_password,
        public readonly string $kafka_topic_external_events,
        public readonly string $kafka_group_id,
        public readonly string $kafka_group_id_prefix,
        public readonly ?string $keycloak_url = null,
        public readonly ?string $bbp_client_id = null,
        public readonly ?string $bbp_client_secret = null,
    ){}

    #[Override]
    public function toArray(): array
    {
        return [
            'server' => $this->server,
            'port' => $this->port,
            'login' => $this->login,
            'password' => $this->password,
            'name' => $this->name,
            'history_base_url' => $this->history_base_url,
            'frontoffice_base_url' => $this->frontoffice_base_url,
            'frontoffice_api_key' => $this->frontoffice_api_key,
            'default_transfer_asset_id' => $this->default_transfer_asset_id,
            'kafka_bootstrap_servers' => $this->kafka_bootstrap_servers,
            'kafka_username' => $this->kafka_username,
            'kafka_password' => $this->kafka_password,
            'kafka_topic_external_events' => $this->kafka_topic_external_events,
            'kafka_group_id' => $this->kafka_group_id,
            'kafka_group_id_prefix' => $this->kafka_group_id_prefix,
            'keycloak_url' => $this->keycloak_url,
            'bbp_client_id' => $this->bbp_client_id,
            'bbp_client_secret' => $this->bbp_client_secret,
        ];
    }

    #[Override]
    public function platformSlug(): string
    {
        return 'b2t';
    }
}