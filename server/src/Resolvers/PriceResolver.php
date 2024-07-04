<?php 

namespace App\Resolvers;




use PDOException;
use RuntimeException;
use App\Database\DatabaseContext;

class PriceResolver {
  
  private $dbContext; 
 
  public function __construct(DatabaseContext $dbContext){

    $this->dbContext =$dbContext;
  }
  

 public function getPrices() {
    try {
        $prices = $this->dbContext->getAll("prices");
        return json_encode($prices); // Convert array to JSON string
    } catch (PDOException $e) {
        throw new RuntimeException("Failed to fetch prices: " . $e->getMessage());
    }
}}
?>