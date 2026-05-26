<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class BulkClosePositionsCommand implements CommandInterface
{
    public function __construct(
        // B2Trader account ID.
        public readonly string $login,

        // Lista de IDs de posición a cerrar.
        /** @var string[] */
        public readonly array $position_ids,

        // Monto parcial de lote a cerrar (opcional).
        public readonly ?string $partial_lot = null,

        // Clave de desduplicación para idempotencia (opcional).
        public readonly ?string $deduplication_key = null,
    ) {}

    public function toArray(): array
    {
        return [
            'login' => $this->login,
            'position_ids' => $this->position_ids,
            'partial_lot' => $this->partial_lot,
            'deduplication_key' => $this->deduplication_key,
        ];
    }
}