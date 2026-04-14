<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Mmt\TradingServiceSdk\Enums\LanguagesEnum;

class UpdateUserCommand implements CommandInterface
{
    public function __construct(
        public string $login,
        public ?string $group = null,
        public ?string $email = null,
        public ?int $leverage = null,
        public ?string $first_name = null,
        public ?string $last_name = null,
        public ?string $company = null,
        public ?LanguagesEnum $language = null,
        public ?string $country = null,
        public ?string $city = null,
        public ?string $state = null,
        public ?string $zip_code = null,
        public ?string $address = null,
        public ?string $phone = null,
        public ?string $comment = null,
    ) {}

    public function toArray(): array
    {
        $payload = [
            'login' => $this->login,
            'group' => $this->group,
            'email' => $this->email,
            'leverage' => $this->leverage,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'company' => $this->company,
            'language' => $this->language?->value,
            'country' => $this->country,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'address' => $this->address,
            'phone' => $this->phone,
            'comment' => $this->comment,
        ];

        return array_filter($payload, fn ($v) => ! is_null($v));
    }
}
