<?php 

namespace App\Resolve;
use App\Database\DatabaseContext;




class PriceResolver {
  
  private $dbContext; 
 
  public function __construct(DatabaseContext $dbContext){

    $this->dbContext =$dbContext;
  }
  

  public  function getPrices($rootValue, $args, $context) {
      return $this->dbContext->getAll("prices");
}
}