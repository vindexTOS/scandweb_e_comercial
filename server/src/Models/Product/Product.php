<?php 


namespace App\Models\Product;

use Attribute;
use App\Models\Category;
use App\Models\Price\Price;
use App\Models\Gallery\Gallery;

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
    
    
}
