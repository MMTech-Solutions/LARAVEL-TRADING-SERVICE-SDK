<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

class PositionItem
{
    public function __construct(
        /**
         * @var string ID del ticket de posición.
         */
        public string $id,

        /**
         * @var string Login de la cuenta (propietario de la posición).
         */
        public string $login,

        /**
         * @var string Símbolo, por ejemplo "EURUSD".
         */
        public string $symbol,

        /**
         * @var float Volumen en lotes.
         */
        public float $volume = 0.0,

        /**
         * @var float Precio de apertura.
         */
        public float $open_price = 0.0,

        /**
         * @var float Precio actual.
         */
        public float $current_price = 0.0,

        /**
         * @var float Stop loss (0 = ninguno).
         */
        public float $sl = 0.0,

        /**
         * @var float Take profit (0 = ninguno).
         */
        public float $tp = 0.0,

        /**
         * @var float Swap.
         */
        public float $swap = 0.0,

        /**
         * @var float Ganancia/pérdida flotante.
         */
        public float $profit = 0.0,

        /**
         * @var string Comentario de la posición.
         */
        public string $comment = '',

        /**
         * @var string Hora de apertura ("TimeCreate") en UTC ISO 8601, ej. "2026-03-23T20:50:23Z".
         */
        public string $time = ''
    ) {}
}
