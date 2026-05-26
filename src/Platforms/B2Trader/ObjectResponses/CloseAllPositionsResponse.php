<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\ObjectResponses;

final class CloseAllPositionsResponse
{
    public function __construct(
        /** @var Position[] */
        public readonly array $positions,
        /** @var string[] */
        public readonly array $order_ids,
    ) {}
}