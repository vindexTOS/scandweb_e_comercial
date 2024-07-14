<?php 

namespace App\Models\Gallery;

use PDOException;
use RuntimeException;
use App\Database\DatabaseContext;
use App\Models\Gallery\GalleryInterface;

abstract class AbstractGallery implements GalleryInterface {
    protected string $url;
    protected int $product_id;

    public function __construct(string $url, int $product_id) {
        $this->url = $url;
        $this->product_id = $product_id;
    }

    abstract public function getUrl(): string;
    abstract public function getProductId(): int;

    public static function getGalleryWithProductId(DatabaseContext $dbContext, int $productId = null): array {
        try {
            $query = "SELECT * FROM gallery WHERE product_id = :productId";
            $galleryData = $dbContext->getAll($query, [':productId' => $productId]);

            $gallery = [];
            foreach ($galleryData as $data) {
                $gallery[] = new static($data['url'], $data['product_id']);
            }

            return $gallery;
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch gallery: " . $e->getMessage());
        }
    }
}