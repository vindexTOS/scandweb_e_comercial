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

    public static function getAllProducts(DatabaseContext $dbContext): array {
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

                $galleryArray = [];
                foreach ($gallery as $item) {
                    $galleryArray[] = $item->getUrl();
                }

                $products[] = [
                    'id' => $productData['graphqlId'],
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

            header('Content-Type: application/json');
            return $products;
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch products: " . $e->getMessage());
        }
    }
}