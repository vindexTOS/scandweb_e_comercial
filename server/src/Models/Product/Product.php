<?php 


namespace App\Models\Product;


use PDOException;
use RuntimeException;
use App\Models\Price\Price;
use App\Models\Gallery\Gallery;
use App\Database\DatabaseContext;
use App\Models\Category\Category;
use App\Models\Attribute\AttributeSet;
use App\Models\Attribute\Attribute;

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
    private int $category_id; 
    
    
    public function __construct(string $id, string $name, bool $inStock,   string $description, string $category, Attribute $attributes, Price $price,  Gallery $gallery ,string $brand, int $category_id){
        $this->id = $id;
        $this->name = $name;
        $this->inStock = $inStock;
        $this->description = $description;
        $this->category= $category;
        $this->attributes = $attributes;
        $this->price = $price;
        $this->brand = $brand;
        $this->category_id = $category_id;
    }
    
    
    
    
    
    public static function getAllProducts(DatabaseContext $dbContext) {
        try {
            $query = "SELECT * FROM products";
            
            $productsData = $dbContext->getAll($query);
            
            $products = [];
            foreach ($productsData as $productData) {
                
                
                
                $prices = Price::getAllPrices($dbContext, $productData['id']);
                $gallery = Gallery::getGalleryWithProductId($dbContext, $productData['id']);
                $category = Category::getCategory($dbContext, $productData['category']);
                $attributes = Attribute::getAttributes($dbContext, $productData['id']);
                $priceArray = [];
                foreach ($prices as $price) {
                    $priceArray[] = $price->toArray();
                }
                
                $galleryArray =[];
                foreach ($gallery as $item) {
                    $galleryArray[] = $item->getUrl(); 
                }
                
                $products[] = [
                    'id' => $productData['graphqlId'],
                    
                    'name' => $productData['name'],
                    "inStock"=> $productData["inStock"] == 0 ? false : true,
                    'gallery' => $galleryArray, 
                    "description"=> $productData[  "description"] ,
                    'attributes'=> $attributes,
                    "category"=> $category->getName() ,
                    'prices' => $priceArray,
                    "brand"=>$productData["brand"]
                ];
            }
            
            // Output JSON
            header('Content-Type: application/json');
            echo json_encode($products);
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch products: " . $e->getMessage());
        }
    }
    
    public function getCategoryId():int {
        return $this->category_id;
    }
    
    // public function getProductName():string {
    //      return $this->name;
    // }
}
