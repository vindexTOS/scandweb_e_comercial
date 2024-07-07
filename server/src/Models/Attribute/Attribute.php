<?php 
namespace App\Models\Attribute;

use App\Models\AttributeSet;

class Attribute
{
    private int $id;
    private string $displayValue;
    private string $value;
     public function __construct(int $id, string $displayValue, string $value  )
    {
        $this->id = $id;
        $this->displayValue = $displayValue;
        $this->value = $value;
     }
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function getDisplayValue(): string
    {
        return $this->displayValue;
    }
    
    public function getValue(): string
    {
        return $this->value;
    }
}