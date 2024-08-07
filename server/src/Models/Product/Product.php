<?php 

namespace App\Models\Product;

use App\Models\Price\Price;
use App\Models\Gallery\Gallery;
use App\Models\Category\Category;
use App\Models\Attribute\Attribute;
use App\Database\DatabaseContext;

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
        
        public function getCategoryId(): int {
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