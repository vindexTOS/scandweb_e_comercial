<?php 
namespace App\Models\Attribute;

use PDOException;
use RuntimeException;
use App\Models\Attribute\AttributeSet;
use App\Database\DatabaseContext;


class Attribute
{
    private int $id;
    private string $name;
    private string $type;
    private array $items;
    public function __construct( int $id, string $name, string $type ,array $items )
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
    }
    
    
    public static function getAttributes(DatabaseContext $dbContext, int $productId){
        try {
            $query = "SELECT * FROM attribute WHERE product_id = :productId;";
            $attributes = $dbContext->getAll($query, [':productId' => $productId] );
            
            $result = [];
            
            foreach($attributes as $attribute){
                $items =[];
                $item = AttributeSet::getAttributeSet($dbContext, $attribute['id'] );
                
                
                foreach($item as $ite){
                    $items[] = $ite->toArray();
                }
                
                $result[] = [
                    'id' => $attribute['type'],
                    'items' => $items,
                    'name' => $attribute['name'],  
                    'type' => $attribute['type'],  
                    '__typename' => 'AttributeSet'
                ];
            }
            if (!$attributes) {
                return null;
            }
            
            return $result;
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch attributes: " . $e->getMessage());
        }
    }
    
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function getType(): string
    {
        return $this->type;
    }
    // public function getItems() 
    // {
    //     return $this->items;
    // }
}