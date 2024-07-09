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
    
    public function getLabel(): string
    {
        return $this->label;
    }
    
    public function getSymbol(): string
    {
        return $this->symbol;
    }
    
}