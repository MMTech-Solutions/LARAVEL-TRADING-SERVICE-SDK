<?php

namespace Mmt\TradingServiceSdk\Enums;

use Illuminate\Support\Str;
use Mmt\TradingServiceSdk\Exceptions\PlatformNotSupportedException;

enum PlatformEnum: int
{
    case MT5 = 1;
    case B2T = 2;

    public static function tryFromString(string $platform): self
    {
        return match(strtolower($platform))
        {
            'mt5' => self::MT5,
            'b2t' => self::B2T,
            default => throw new PlatformNotSupportedException(),
        };
    }

    /** @deprecated Use toLowerCases instead */
    public static function toLowerString(): array
    {
        return array_map(fn(self $platform) => strtolower($platform->name), self::cases());
    }

    public static function toLowerCases(): array
    {
        return array_map(fn(self $platform) => strtolower($platform->name), self::cases());
    }

    public function toLowerCase(): string
    {
        return strtolower($this->name);
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