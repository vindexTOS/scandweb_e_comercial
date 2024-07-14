<?php
namespace App\Models\Category;

 
class Category extends AbstractCategory {
    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }
}
