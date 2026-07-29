<?php

namespace Mmt\TradingServiceSdk\Platforms\CTrader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Override;

/**
 * Command to retrieve orders by their ticket IDs.
 */
class GetOrdersByTicketsCommand implements CommandInterface
{
    public function __construct(
        /** @var string[] List of order ticket IDs to look up. */
        public readonly array $order_ids,
    ) {}

    /**
     * Return the command fields as an associative array.
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(): array
    {
        return [
            'order_ids' => $this->order_ids,
        ];
    }
}
