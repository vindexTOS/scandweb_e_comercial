<?php

namespace App\Models\Price;

use App\Models\Currency\Currency;

class Price extends AbstractPrice {
    public function __construct(int $id, float $amount, Currency $currency) {
        parent::__construct($id, $amount, $currency);
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'currency' => array_merge($this->currency->toArray(), ['__typename' => 'Currency']),
            '__typename' => 'Price'
        ];
    }
}