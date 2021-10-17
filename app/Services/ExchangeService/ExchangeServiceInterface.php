<?php

namespace Shopapp\Services\ExchangeService;

interface ExchangeServiceInterface
{
    /**
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return float
     */
    public function convert(string $from, string $to, float $amount): float;
}
