<?php 

namespace App\Models\Order;

class Order extends AbstractOrder {
    public function __construct(int $id, int $product_id) {
        parent::__construct($id, $product_id);
    }

 }
