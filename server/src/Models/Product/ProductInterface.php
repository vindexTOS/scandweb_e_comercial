<?php
namespace App\Models\Product;

use App\Models\Price\Price;
use App\Models\Gallery\Gallery;
use App\Database\DatabaseContext;
use App\Models\Attribute\Attribute;

interface ProductInterface {
    
    
    
    
    public static function getAllProducts(DatabaseContext $dbContext, string $category ): array;
    public function getCategoryId(): int;
    public function getId(): string;
    public function getName(): string ;
    public function isInStock(): bool ;
    public function getDescription(): string;
    public function getCategory(): string ;
    public function getAttributes(): Attribute;
    public function getPrice(): Price ;
    public function getGallery(): Gallery;
    public function getBrand(): string ;
    
}