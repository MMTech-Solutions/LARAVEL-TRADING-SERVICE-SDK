<?php

namespace Mmt\TradingServiceSdk\Contracts;

interface CommandInterface
{
    public function toArray(): array;
}