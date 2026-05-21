<?php

namespace Mmt\TradingServiceSdk\Platforms\Shared\ObjectResponses;

/**
 * Response from POST /v1/admin/brokers/connect/{platform}.
 */
class BrokerConnectionResponse
{
    public function __construct(
        public readonly string $connection_id,
        public readonly string $broker_key,
        /** Platform API URL prefix, e.g. "/v1/mt5". */
        public readonly string $platform_api_prefix = '',
        /** Broker key platform label, e.g. "MT5". */
        public readonly string $broker_key_platform = '',
        /** Whether events ingestion is enabled for this connection. */
        public readonly ?bool $events_ingestion_enabled = null,
    ) {}
}