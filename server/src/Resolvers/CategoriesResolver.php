<?php 


namespace App\Resolvers;

use Error;
use App\Database\DatabaseContext;
use App\Models\Category\Category;

class CategoriesResolver {
    
    
    private $dbContext;
    
    
    
    public function __construct(DatabaseContext $dbContext){
        $this->dbContext = $dbContext;
    }
    
    public function getCategories(){
        try {
            return  Category::getAllCategories($this->dbContext) ;
        } catch (\Throwable $e) {
            throw new Error('Failed to fetch categories: ' . $e->getMessage());
            
        }
    }
    
    
    
    
    
}