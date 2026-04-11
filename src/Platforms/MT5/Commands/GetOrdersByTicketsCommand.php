<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class GetOrdersByTicketsCommand implements CommandInterface
{
    /**
     * @param string[] $order_ids
     */
    public function __construct(
        public array $order_ids,
    ) {}

    public function toArray(): array
    {
        return [
            'order_ids' => $this->order_ids,
        ];
    }
}
