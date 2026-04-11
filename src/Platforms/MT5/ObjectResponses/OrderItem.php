<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

final class OrderItem
{
    public function __construct(
        /** Order ticket id. */
        public string $id,
        /** Account login (order owner). */
        public string $login,
        /** Symbol (e.g. EURUSD). */
        public string $symbol,
        /** Initial order volume in lots (MT5: IMTOrder.VolumeInitial). */
        public float $volume = 0,
        /** Order price. */
        public float $price = 0,
        /** Order creation / placement (TimeSetup) as UTC ISO 8601, e.g. "2026-03-23T20:50:23Z". */
        public string $time,
        /** Order type. */
        public string $type,
        /** Order state. */
        public string $state,
    ) {}
}