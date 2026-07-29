<?php

declare(strict_types=1);

namespace Mmt\TradingServiceSdk\Platforms\CTrader\DTOs;

/**
 * Represents the full profile data for a CTrader user account.
 */
final readonly class UserData
{
    public function __construct(
        public ?string $login = null,
        public ?string $group = null,
        public ?string $name = null,
        public ?string $first_name = null,
        public ?string $last_name = null,
        public ?string $company = null,
        public ?string $language = null,
        public ?string $country = null,
        public ?string $city = null,
        public ?string $state = null,
        public ?string $zip_code = null,
        public ?string $address = null,
        public ?string $phone = null,
        public ?string $email = null,
        public ?string $comment = null,
        public ?int $leverage = null,
    ) {}
}
