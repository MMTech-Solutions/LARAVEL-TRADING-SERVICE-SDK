<?php

namespace Mmt\TradingServiceSdk\TransportDrivers\Contracts;

interface TransportInterface
{
    public function send(TransportPacket $packet): ResponseResult;
}