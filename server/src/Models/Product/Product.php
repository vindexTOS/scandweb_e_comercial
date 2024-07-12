<?php 


namespace App\Models\Product;


use PDOException;
use RuntimeException;
use App\Models\Price\Price;
use App\Models\Gallery\Gallery;
use App\Database\DatabaseContext;
use App\Models\Category\Category;
use App\Models\Attribute\Attribute;
use App\Models\Product\AbstractProduct;

class Product extends AbstractProduct {
    private Gallery $gallery;
    private string $category;
    private Attribute $attributes;
    private Price $price;
    private string $brand;
    
    public function __construct(
        string $id,
        string $name,
        bool $inStock,
        string $description,
        string $category,
        Attribute $attributes,
        Price $price,
        Gallery $gallery,
        string $brand,
        int $category_id
        ) {
            parent::__construct($id, $name, $inStock, $description, $category_id);
            $this->category = $category;
            $this->attributes = $attributes;
            $this->price = $price;
            $this->gallery = $gallery;
            $this->brand = $brand;
        }
        
        
        
        
        public static function getAllProducts(DatabaseContext $dbContext):array {
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
                
                
                header('Content-Type: application/json');
                return $products ;
            } catch (PDOException $e) {
                throw new RuntimeException("Failed to fetch products: " . $e->getMessage());
            }
        }
        
        public function getCategoryId():int {
            return $this->category_id;
        }
        public function getId(): string {
            return $this->id;
        }
        
        public function getName(): string {
            return $this->name;
        }
        
        public function isInStock(): bool {
            return $this->inStock;
        }
        
        public function getDescription(): string {
            return $this->description;
        }
        
        public function getCategory(): string {
            return $this->category;
        }
        
        public function getAttributes(): Attribute {
            return $this->attributes;
        }
        
        public function getPrice(): Price {
            return $this->price;
        }
        
        public function getGallery(): Gallery {
            return $this->gallery;
        }
        
        public function getBrand(): string {
            return $this->brand;
        }
        
    }
    