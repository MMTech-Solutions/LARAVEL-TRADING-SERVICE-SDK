<?php

namespace Mmt\TradingServiceSdk\Platforms\CTrader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class UpdateUserCommand implements CommandInterface
{
    public function __construct(
        public readonly string $login,
        public readonly ?string $group = null,
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        public readonly ?int $leverage = null,
        public readonly ?string $first_name = null,
        public readonly ?string $last_name = null,
        public readonly ?string $company = null,
        public readonly ?string $language = null,
        public readonly ?string $country = null,
        public readonly ?string $city = null,
        public readonly ?string $state = null,
        public readonly ?string $zip_code = null,
        public readonly ?string $address = null,
        public readonly ?string $phone = null,
        public readonly ?string $comment = null,
        public readonly ?string $access_rights = null,
    ) {}

    public function toArray(): array
    {
        $payload = [
            'login' => $this->login,
            'group' => $this->group,
            'name' => $this->name,
            'email' => $this->email,
            'leverage' => $this->leverage,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'company' => $this->company,
            'language' => $this->language,
            'country' => $this->country,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'address' => $this->address,
            'phone' => $this->phone,
            'comment' => $this->comment,
            'access_rights' => $this->access_rights,
        ];

        // Always include login; filter null values from optional fields
        return array_filter($payload, function ($value, $key) {
            return $key === 'login' || ! is_null($value);
        }, ARRAY_FILTER_USE_BOTH);
    }
}
