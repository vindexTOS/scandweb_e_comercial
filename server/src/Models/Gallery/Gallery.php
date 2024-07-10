<?php
namespace App\Models\Gallery;

use PDOException;
use RuntimeException;
use App\Database\DatabaseContext;

class Gallery {
    
    
    private string $url;
    private int $product_id;
    
    public function __construct(string $url, int $product_id){
        
        $this->url = $url;
        $this->product_id = $product_id;
    }
    
    public static function getGalleryWithProductId(DatabaseContext $dbContext, int $productId = null) {
        try {
            $query = "SELECT * FROM gallery WHERE product_id = :productId";
            $galleryData = $dbContext->getAll($query, [':productId' => $productId]);
            
            $gallery = [];
            foreach ($galleryData as $data) {
                $gallery[] = new self($data['url'], $data['product_id']);
            }
            
            return $gallery;
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch gallery: " . $e->getMessage());
        }
    }
    public function getUrl(): string {
        return $this->url;
    }
    
    
}