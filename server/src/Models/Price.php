<?php

namespace App\Models;

class Price
{
    private float $amount;
    private Currency $currency;
    private int $product_id;
    public function __construct(float $amount, Currency $currency, int $product_id)
    {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->product_id = $product_id;
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