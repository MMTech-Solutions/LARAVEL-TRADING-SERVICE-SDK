<?php

namespace Mmt\TradingServiceSdk\Platforms\CTrader\Commands;

use Mmt\TradingServiceSdk\Contracts\ConnectCommandInterface;
use Override;

/**
 * Broker connect command for CTrader (Spotware).
 *
 * The platform is sent as a URL path segment (POST /v1/admin/brokers/connect/ctrader),
 * not in the request body.
 */
class CTraderConnectCommand implements ConnectCommandInterface
{
    public function __construct(
        // Required connection fields
        public readonly string $server,
        public readonly int $port,
        public readonly string $login,
        public readonly string $password,

        // Optional identification fields
        public readonly ?string $name = null,
        public readonly ?string $broker_name = null,

        // Optional streaming / polling intervals
        public readonly ?float $open_positions_poll_interval_sec = null,
        public readonly ?float $closed_positions_poll_interval_sec = null,
        public readonly ?float $margin_poll_interval_sec = null,

        // Optional Hybrid Manager API fields
        public readonly ?string $manager_proxy_host = null,
        public readonly ?int $manager_proxy_port = null,
        public readonly ?string $manager_plant_id = null,
        public readonly ?string $manager_environment_name = null,
        public readonly ?bool $manager_verify_tls = null,
        public readonly ?string $manager_server_hostname = null,
        public readonly ?string $manager_ca_file = null,
    ) {}

    /**
     * Build an instance from a plain associative array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            server: $data['server'],
            port: (int) $data['port'],
            login: $data['login'],
            password: $data['password'],
            name: $data['name'] ?? null,
            broker_name: $data['broker_name'] ?? null,
            open_positions_poll_interval_sec: isset($data['open_positions_poll_interval_sec'])
                ? (float) $data['open_positions_poll_interval_sec']
                : null,
            closed_positions_poll_interval_sec: isset($data['closed_positions_poll_interval_sec'])
                ? (float) $data['closed_positions_poll_interval_sec']
                : null,
            margin_poll_interval_sec: isset($data['margin_poll_interval_sec'])
                ? (float) $data['margin_poll_interval_sec']
                : null,
            manager_proxy_host: $data['manager_proxy_host'] ?? null,
            manager_proxy_port: isset($data['manager_proxy_port'])
                ? (int) $data['manager_proxy_port']
                : null,
            manager_plant_id: $data['manager_plant_id'] ?? null,
            manager_environment_name: $data['manager_environment_name'] ?? null,
            manager_verify_tls: isset($data['manager_verify_tls'])
                ? (bool) $data['manager_verify_tls']
                : null,
            manager_server_hostname: $data['manager_server_hostname'] ?? null,
            manager_ca_file: $data['manager_ca_file'] ?? null,
        );
    }

    /**
     * Return all non-null fields as an associative array.
     * Null values are stripped so the broker API only receives explicitly provided settings.
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(): array
    {
        return array_filter([
            'server'                              => $this->server,
            'port'                                => $this->port,
            'login'                               => $this->login,
            'password'                            => $this->password,
            'name'                                => $this->name,
            'broker_name'                         => $this->broker_name,
            'open_positions_poll_interval_sec'    => $this->open_positions_poll_interval_sec,
            'closed_positions_poll_interval_sec'  => $this->closed_positions_poll_interval_sec,
            'margin_poll_interval_sec'            => $this->margin_poll_interval_sec,
            'manager_proxy_host'                  => $this->manager_proxy_host,
            'manager_proxy_port'                  => $this->manager_proxy_port,
            'manager_plant_id'                    => $this->manager_plant_id,
            'manager_environment_name'            => $this->manager_environment_name,
            'manager_verify_tls'                  => $this->manager_verify_tls,
            'manager_server_hostname'             => $this->manager_server_hostname,
            'manager_ca_file'                     => $this->manager_ca_file,
        ], fn (mixed $value): bool => $value !== null);
    }

    #[Override]
    public function platformSlug(): string
    {
        return 'ctrader';
    }
}
