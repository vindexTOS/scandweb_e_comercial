<?php
namespace App\Models\Product;


use PDOException;
use RuntimeException;
use App\Models\Price\Price;
use App\Models\Gallery\Gallery;
use App\Database\DatabaseContext;
use App\Models\Category\Category;
use App\Models\Attribute\Attribute;

abstract class AbstractProduct implements ProductInterface {
    protected string $id;
    protected string $name;
    protected bool $inStock;
    protected string $description;
    protected int $category_id;
    
    public function __construct(string $id, string $name, bool $inStock, string $description, int $category_id) {
        $this->id = $id;
        $this->name = $name;
        $this->inStock = $inStock;
        $this->description = $description;
        $this->category_id = $category_id;
    }
    
    abstract public function getCategoryId(): int;
    abstract public function getId(): string;
    abstract public function getName(): string;
    abstract public function isInStock(): bool;
    abstract public function getDescription(): string;
    abstract public function getCategory(): string;
    abstract public function getAttributes(): Attribute;
    abstract public function getPrice(): Price;
    abstract public function getGallery(): Gallery;
    abstract public function getBrand(): string;
    
    private static function processProductData(array $productData, DatabaseContext $dbContext): array {
        $prices = Price::getAllPrices($dbContext, $productData['id']);
        $gallery = Gallery::getGalleryWithProductId($dbContext, $productData['id']);
        $category = Category::getCategory($dbContext, $productData['category']);
        $attributes = Attribute::getAttributes($dbContext, $productData['id']);
        
        $priceArray = [];
        foreach ($prices as $price) {
            $priceArray[] = $price->toArray();
        }
        
        $galleryArray = [];
        foreach ($gallery as $item) {
            $galleryArray[] = $item->getUrl();
        }
        
        return [
            'id' => $productData['graphqlId'],
            "product_id"=>$productData['id'],
            'name' => $productData['name'],
            'inStock' => $productData['inStock'] == 0 ? false : true,
            'gallery' => $galleryArray,
            'description' => $productData['description'],
            'attributes' => $attributes,
            'category' => $category->getName(),
            'prices' => $priceArray,
            'brand' => $productData['brand']
        ];
    }

    public static function getAllProducts(DatabaseContext $dbContext, ?string $category): array {
        try {
            $query = "SELECT * FROM products";
            $params = [];
            
            if ($category !== null && $category !== "1") {
                $query .= " WHERE category = :category";
                $params[':category'] = $category;
            }
            
            $productsData = $dbContext->getAll($query, $params);
            
            $products = [];
            foreach ($productsData as $productData) {
                $products[] = self::processProductData($productData, $dbContext);
            }
            
            header('Content-Type: application/json');
            return $products;
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch products: " . $e->getMessage());
        }
    }

    public static function getSingleProduct(DatabaseContext $dbContext, string $id) {
        try {
            $query = 'SELECT * FROM products WHERE graphqlId = :graphqlId';
            $productData = $dbContext->getSingle($query, ['graphqlId' => $id]); 
            
            $product = self::processProductData($productData, $dbContext);
            
            header('Content-Type: application/json');
            return $product;
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch product: " . $e->getMessage());
        }
    }
}