<?php 


namespace App\Models;

use App\Models\Category;


class Product {
    private  int $id;
    private string  $name ;
    private boolean  $inStock ;
    private  string $description;
    private int $category_id;
    private array $attributes;
    private array $prices;
    private string $brand;
    
    
    
    public function __construct(int $id, string $name, boolean $inStock,   string $description, Category $category, array $attributes, array $price, string $brand){
        $this->id = $id;
        $this->name = $name;
        $this->inStock = $inStock;
        $this->description = $description;
        $this->category_id = $category_id;
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
