<?php 

namespace App\Resolvers;




use Error;
use PDOException;
use RuntimeException;


use App\Models\Product\Product;
use App\Database\DatabaseContext;
use GraphQL\Type\Definition\ResolveInfo;

class ProductResolver {
  
  private $dbContext; 
  
  public function __construct(DatabaseContext $dbContext){
    
    $this->dbContext =$dbContext;
  }
  
  
  
  
  public function getProducts(?string $category){
    try {
      // return json_encode(Product::getAllProducts($this->dbContext));
      return Product::getAllProducts($this->dbContext, $category);
      
    } catch (\Exception $e) {
      var_dump($e);
      throw new Error('Failed to fetch prices: ' . $e->getMessage());
    }
  }
}
?>