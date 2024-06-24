<?php

namespace App\Models;

class Price
{
    private float $amount;
    private Currency $currency;
    
    public function __construct(float $amount, Currency $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }
    
    public function getAmount(): float
    {
        return $this->amount;
    }
    
    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}