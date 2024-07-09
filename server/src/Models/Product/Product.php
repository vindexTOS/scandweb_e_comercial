<?php 


namespace App\Models\Product;

use Attribute;
use PDOException;
use RuntimeException;
use App\Models\Category;
use App\Models\Price\Price;
use App\Models\Gallery\Gallery;
use App\Database\DatabaseContext;

class Product {
    private  string $id;
    private string  $name ;
    private bool  $inStock ;
    private Gallery $gallery; 
    
    private  string $description;
    private string $category;
    private Attribute $attributes;  
    private Price $price;
    private string $brand;
    
    
    
    public function __construct(string $id, string $name, bool $inStock,   string $description, string $category, Attribute $attributes, Price $price,  Gallery $gallery ,string $brand){
        $this->id = $id;
        $this->name = $name;
        $this->inStock = $inStock;
        $this->description = $description;
        $this->category= $category;
        $this->attributes = $attributes;
        $this->price = $price;
        $this->brand = $brand;
    }
    
    
    public static function getAllProducts(DatabaseContext $dbContext)  {
        try {
            $query = "
       SELECT * FROM products;
";
            
            
            
            $pricesData = $dbContext->getAll($query);
            // $jsonPrices = json_encode( $pricesData);
            $prices = [];
            for ($i = 0; $i < count($pricesData); $i++) {
                $price = Price::getAllPrices($dbContext, $pricesData[$i]["id"]);
                
                // var_dump($price); 
                
                if ($price !== null) {
                    
                    array_push($prices, $price);
                }
            }
            
            
            // Output JSON
            header('Content-Type: application/json');
            // echo  $prices;
            var_dump($prices);
            return json_encode($prices) ;
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch prices: " . $e->getMessage());
        }
    }
    
    
}
