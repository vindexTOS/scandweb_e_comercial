<?php 

namespace App\Resolvers;




use Error;
use PDOException;
use RuntimeException;
use App\Models\Price\Price;

use App\Models\Product\Product;
use App\Database\DatabaseContext;
use GraphQL\Type\Definition\ResolveInfo;

class PriceResolver {
  
  private $dbContext; 
  
  public function __construct(DatabaseContext $dbContext){
    
    $this->dbContext =$dbContext;
  }
  
  
  public function getPrices( ) {
    try {
      return Price::getAllPrices($this->dbContext);
    } catch (\Exception $e) {
      var_dump($e);
      throw new Error('Failed to fetch prices: ' . $e->getMessage());
    }
  }
  
  
  public function getProducst(){
    try {
      return json_encode(Product::getAllProducts($this->dbContext));
      
      
    } catch (\Exception $e) {
      var_dump($e);
      throw new Error('Failed to fetch prices: ' . $e->getMessage());
      
    }
  }
}
?>