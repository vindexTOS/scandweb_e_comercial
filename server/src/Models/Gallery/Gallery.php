<?php
namespace App\Models\Gallery;

class Gallery extends AbstractGallery {
    public function __construct(string $url, int $product_id) {
        parent::__construct($url, $product_id);
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function getProductId(): int {
        return $this->product_id;
    }
}
