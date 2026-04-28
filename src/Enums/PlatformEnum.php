<?php

namespace Mmt\TradingServiceSdk\Enums;

use Illuminate\Support\Str;
use Mmt\TradingServiceSdk\Exceptions\PlatformNotSupportedException;

enum PlatformEnum: int
{
    case MT5 = 1;

    public static function tryFromString(string $platform): self
    {
        return match(strtolower($platform))
        {
            'mt5' => self::MT5,
            default => throw new PlatformNotSupportedException(),
        };
    }

    public static function toLowerString(): array
    {
        return array_map(fn(self $platform) => strtolower($platform->name), self::cases());
    }

    public function label(): string
    {
        return Str::ucfirst(strtolower($this->name));
    }

    public static function serialized(): array
    {
        return array_map(fn(self $platform) => [
            'name' => $platform->name,
            'label' => $platform->label(),
            'value' => $platform->value,
        ], self::cases());
    }
}