<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\DTOs;

use Mmt\TradingServiceSdk\WireHydration\Attributes\WireMapped;

#[WireMapped]
final class Account
{
    public function __construct(
        /** Created trading account id (B2T account id). */
        public readonly string $account_id,
        /** Owner Keycloak user UUID. */
        public readonly string $user_id,
        /** Account group UUID. */
        public readonly string $group_id,
        /** Account display name. */
        public readonly string $name,
        /** Account type (e.g. Hedging). */
        public readonly string $type,
        /** Public account id when assigned by B2T (may be numeric). */
        public readonly ?string $public_account_id = null,
    ) {}
}
