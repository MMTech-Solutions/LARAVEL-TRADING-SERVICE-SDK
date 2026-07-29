<?php

namespace Mmt\TradingServiceSdk\Platforms\CTrader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Mmt\TradingServiceSdk\Platforms\CTrader\Enums\TransactionTypeEnum;
use Override;

/**
 * Command to perform a balance transaction (deposit or withdrawal) on a CTrader trading account.
 *
 * Used for both POST /v1/ctrader/connections/{connection_id}/transactions/change
 * and POST /v1/ctrader/connections/{connection_id}/transactions/set.
 */
class TransactionCommand implements CommandInterface
{
    public function __construct(
        // Required fields
        public readonly string $login,
        public readonly float $amount,

        // Optional fields
        public readonly ?string $comment = null,
        public readonly ?TransactionTypeEnum $type = null,
    ) {}

    /**
     * Serialize the command to an associative array.
     * Required fields are always included; null optionals are stripped.
     * The transaction type is serialized to its string value, not the enum instance.
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(): array
    {
        $data = [
            'login'  => $this->login,
            'amount' => $this->amount,
        ];

        if ($this->comment !== null) {
            $data['comment'] = $this->comment;
        }

        if ($this->type !== null) {
            $data['type'] = $this->type->value;
        }

        return $data;
    }
}
