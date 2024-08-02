<?php 

namespace App\Resolvers;

use Error;
use App\Database\DatabaseContext;
use App\Models\Order\Order;

class PlaceOrderResolver {
    private $dbContext; 
  
    public function __construct(DatabaseContext $dbContext){
        $this->dbContext = $dbContext;
    }
    public function makeOrder( $orderInput) {
        try {
            //  $orderId = Order::createOrder($this->dbContext, $orderInput);\
            echo $orderInput;
              return $orderInput;
        } catch (\Throwable $e) {
            throw new Error('Failed to make order: ' . $e->getMessage());
        }
    }
}
