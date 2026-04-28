<?php

namespace Mmt\TradingServiceSdk\WireHydration\Attributes;

use Attribute;

/**
 * Maps a DTO or a public property to a wire (JSON) shape. Reuse the same attribute on the class
 * (full public property hydration) or on individual public properties (opt-in per property when
 * the class is not wire-mapped as a whole).
 *
 * @property string|null $wireKey When set, the value is read from this key in the decoded array; when
 *                            null, the source key is the property's name in PHP.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY)]
final class WireMapped
{
    public function __construct(
        public readonly ?string $wireKey = null,
    ) {}
}
