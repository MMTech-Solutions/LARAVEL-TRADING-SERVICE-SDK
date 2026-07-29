<?php

namespace Mmt\TradingServiceSdk\Platforms\CTrader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public readonly string $password,
        public readonly string $group,
        public readonly string $email,
        public readonly int $leverage,
        public readonly ?string $login = null,
        public readonly ?string $agent_account = null,
        public readonly ?string $password_investor = null,
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
        public readonly ?string $deposit_currency = null,
        public readonly ?string $access_rights = null,
    ) {}

    public function toArray(): array
    {
        $payload = [
            'login' => $this->login,
            'password' => $this->password,
            'group' => $this->group,
            'email' => $this->email,
            'leverage' => $this->leverage,
            'agent_account' => $this->agent_account,
            'password_investor' => $this->password_investor,
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
            'deposit_currency' => $this->deposit_currency,
            'access_rights' => $this->access_rights,
        ];

        // Filter out properties with null values
        return array_filter($payload, function ($value) {
            return ! is_null($value);
        });
    }
}
