<?php 

namespace App\Resolvers;




use Error;
use PDOException;
use RuntimeException;
use App\Database\DatabaseContext;
use App\Models\PriceModels\Price;
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
  
}
?>