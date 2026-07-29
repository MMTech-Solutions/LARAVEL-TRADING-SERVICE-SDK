<?php

namespace Mmt\TradingServiceSdk\Platforms\CTrader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Override;

/**
 * Command to change the password of a CTrader trading account.
 *
 * Sends a POST request to /v1/ctrader/connections/{connection_id}/users/change-password.
 */
class ChangePasswordCommand implements CommandInterface
{
    public function __construct(
        // Required fields
        public readonly string $login,
        public readonly string $new_password,

        // Optional fields
        public readonly ?bool $is_investor = null,
    ) {}

    /**
     * Serialize the command to an associative array.
     * Required fields are always included; null optionals are stripped.
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(): array
    {
        $data = [
            'login'        => $this->login,
            'new_password' => $this->new_password,
        ];

        if ($this->is_investor !== null) {
            $data['is_investor'] = $this->is_investor;
        }

        return $data;
    }
}
