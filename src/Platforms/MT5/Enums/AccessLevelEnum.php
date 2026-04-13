<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Enums;

enum AccessLevelEnum: int
{
    case FULL_ACCESS = 1;
    case NO_LOGIN = 2;
    case NO_TRADING = 3;
    case FULLY_BLOCKED = 4;

    /**
     * @return string[]
     */
    public static function lowerCases(): array
    {
        return array_map(fn(AccessLevelEnum $level) => strtolower($level->name), self::cases());
    }
}