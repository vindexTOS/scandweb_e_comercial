<?php
namespace App\Models\Currency;

namespace App\Models\Currency;

class Currency extends AbstractCurrency {
    public function toArray(): array {
        return [
            'label' => $this->label,
            'symbol' => $this->symbol,
            '__typename' => 'Currency'
        ];
    }
}