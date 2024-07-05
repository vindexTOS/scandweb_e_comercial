<?php
namespace App\Models\CurrencyModels;

class Currency
{
    private int $id;
    private string $label;
    private string $symbol;
    
    public function __construct(string $label, string $symbol, int $id)
    {   
        $this->id = $id;
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
    public function getId():int {
        return $this->id;
    }
}