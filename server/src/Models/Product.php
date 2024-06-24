<?php 


namespace App\Models;

use App\Models\Category;


class Product {
    private  int $id;
    private string  $name ;
    private boolean  $inStock ;
    private  array $gallery;
    private  string $description;
    private Category $category;
    private array $attributes;
    private array $prices;
    private string $brand;
    
    
    
    public function __construct(int $id, string $name, boolean $inStock, array $gallery, string $description, Category $category, array $attributes, array $price, string $brand){
        $this->id = $id;
        $this->name = $name;
        $this->inStock = $inStock;
        $this->gallery = $gallery;
        $this->description = $description;
        $this->category = $category;
        $this->attributes = $attributes;
        $this->prices = $prices;
        $this->brand = $brand;
    }
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function isInStock(): bool
    {
        return $this->inStock;
    }
    
    public function getGallery(): array
    {
        return $this->gallery;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }
    
    public function getCategory(): Category
    {
        return $this->category;
    }
    
    public function getAttributes(): array
    {
        return $this->attributes;
    }
    
    public function getPrices(): array
    {
        return $this->prices;
    }
    
    public function getBrand(): string
    {
        return $this->brand;
    }
}
