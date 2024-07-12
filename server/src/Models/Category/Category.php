<?php
namespace App\Models\Category;

use PDOException;
use RuntimeException;
use App\Database\DatabaseContext;

class Category {
    private int $id;
    private string $name;
    
    public function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }
    
    
    public static function getCategory(DatabaseContext $dbContext, int $id = null) {
        try {
            $query = "SELECT * FROM categories WHERE id = :id";
            $categoryData = $dbContext->getSingle($query, [":id" => $id]);  
            
            if (!$categoryData) {
                return null;  
            }
            
            return new self($categoryData['id'], $categoryData['name']);
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch category: " . $e->getMessage());
        }
    }
    
    
    public static function getAllCategories (DatabaseContext $dbContext){
        
        try {
            $query = "SELECT * FROM categories";
            
            $allCategories = $dbContext->getAll($query);
            $categories = [];
            foreach($allCategories as $categoryData){
                $category = new self($categoryData['id'], $categoryData['name']);
                
                $categories[] = [
                    "id" => $category->getId(),
                    "name" => $category->getName()
                ];
            }
            header('Content-Type: application/json');
            
            return  $categories;
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch category: " . $e->getMessage());
            
        }
    }
    public function getId(): int {
        return $this->id;
    }
    
    public function getName(): string {
        return $this->name;
    }
}