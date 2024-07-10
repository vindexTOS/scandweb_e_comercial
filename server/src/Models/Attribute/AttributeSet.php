<?php
namespace App\Models\Attribute;

use PDOException;
use RuntimeException;
use App\Database\DatabaseContext;
use App\Models\Attribute\Attribute;


class AttributeSet
{
    
    private int $id;
    private string $displayValue;
    private string $value;
    public function __construct(int $id, string $displayValue, string $value )
    {
        $this->id = $id;
        $this->displayValue = $displayValue;
        $this->value = $value;
        
        
    }
    
    
    public  static function getAttributeSet(DatabaseContext $dbContext, int $attribute_id){
        try {
            
            $query = "SELECT * FROM attribute_set WHERE attribute_id = :attribute_id;";
            
            $attributeSetData = $dbContext->getAll( $query, [":attribute_id"=>$attribute_id]);
            
            $attributeSets = [];
            foreach ($attributeSetData as $data) {
                $attributeSets[] = new self($data['id'], $data['displayValue'], $data['value']   );
            }
            
            return $attributeSets; 
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch attribute_set: " . $e->getMessage());
            
        }
        
        
        
    }
    public function toArray():array {
        return [
            "id"=>$this->id,
            "displayValue"=> $this->displayValue,
            "value"=> $this->value,
            
        ];
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