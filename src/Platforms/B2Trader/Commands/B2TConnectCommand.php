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
        public readonly string $kafka_bootstrap_servers,
        public readonly string $kafka_security_protocol,
        public readonly string $kafka_sasl_mechanism,
        public readonly string $kafka_username,
        public readonly string $kafka_password,
        public readonly string $kafka_external_events_topic,
        public readonly string $kafka_consumer_group_id_prefix,
        public readonly string $kafka_auto_offset_reset,
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
            kafka_bootstrap_servers: $data['kafka_bootstrap_servers'],
            kafka_security_protocol: $data['kafka_security_protocol'],
            kafka_sasl_mechanism: $data['kafka_sasl_mechanism'],
            kafka_username: $data['kafka_username'],
            kafka_password: $data['kafka_password'],
            kafka_external_events_topic: $data['kafka_external_events_topic'],
            kafka_consumer_group_id_prefix: $data['kafka_consumer_group_id_prefix'],
            kafka_auto_offset_reset: $data['kafka_auto_offset_reset'],
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
            'kafka_bootstrap_servers' => $this->kafka_bootstrap_servers,
            'kafka_security_protocol' => $this->kafka_security_protocol,
            'kafka_sasl_mechanism' => $this->kafka_sasl_mechanism,
            'kafka_username' => $this->kafka_username,
            'kafka_password' => $this->kafka_password,
            'kafka_external_events_topic' => $this->kafka_external_events_topic,
            'kafka_consumer_group_id_prefix' => $this->kafka_consumer_group_id_prefix,
            'kafka_auto_offset_reset' => $this->kafka_auto_offset_reset,
        ];
    }

    #[Override]
    public function platformSlug(): string
    {
        return 'b2t';
    }
}
