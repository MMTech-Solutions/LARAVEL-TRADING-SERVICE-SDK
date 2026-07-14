<?php

namespace Mmt\TradingServiceSdk\Contracts;

interface ConnectCommandInterface extends CommandInterface
{
    public function platformSlug(): string;
}
