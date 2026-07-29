<?php

namespace Mmt\TradingServiceSdk\Platforms\CTrader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Override;

/**
 * Command to retrieve orders for a given account login.
 *
 * Optional timestamp filters are omitted from the body when not provided.
 */
class GetOrdersCommand implements CommandInterface
{
    public function __construct(
        // Required account login
        public readonly string $login,

        // Optional time range filters (Unix timestamps)
        public readonly ?int $from_timestamp = null,
        public readonly ?int $to_timestamp = null,
    ) {}

    /**
     * Return the command fields as an associative array.
     * The login is always included; null timestamp filters are stripped.
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(): array
    {
        $data = ['login' => $this->login];

        if ($this->from_timestamp !== null) {
            $data['from_timestamp'] = $this->from_timestamp;
        }

        if ($this->to_timestamp !== null) {
            $data['to_timestamp'] = $this->to_timestamp;
        }

        return $data;
    }
}
