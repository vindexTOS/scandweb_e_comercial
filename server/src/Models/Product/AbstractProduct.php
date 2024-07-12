<?php
namespace App\Models\Product;

use App\Models\Price\Price;
use App\Models\Gallery\Gallery;
use App\Models\Attribute\Attribute;
use App\Models\Product\ProductInterface;


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
    abstract public function getName(): string ;
    abstract public function isInStock(): bool ;
    abstract public function getDescription(): string;
    abstract public function getCategory(): string ;
    abstract public function getAttributes(): Attribute;
    abstract public function getPrice(): Price ;
    abstract public function getGallery(): Gallery;
    abstract public function getBrand(): string ;
    
}