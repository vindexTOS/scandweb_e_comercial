<?php
namespace App\Models\Currency;

class Currency
{
    private string $label;
    private string $symbol;
    
    public function __construct(string $label, string $symbol,  )
    {   
        $this->label = $label;
        $this->symbol = $symbol;
        
    }
    
    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'symbol' => $this->symbol,
            '__typename' => 'Currency'
        ];
    }
}