<?php 
namespace App\Models;

use App\Models\AttributeSet;

class Attribute
{
    private int $id;
    private string $displayValue;
    private string $value;
    private  AttributeSet $attrabiuteSet_id;
    public function __construct(int $id, string $displayValue, string $value, AttributeSet $attrabiuteSet_id )
    {
        $this->id = $id;
        $this->displayValue = $displayValue;
        $this->value = $value;
        $this->attrabiuteSet_id = $attrabiuteSet_id;
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