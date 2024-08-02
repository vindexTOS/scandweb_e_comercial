<?php 

namespace App\Models\Order;

interface OrderInterface {
    public function getId(): int;
    public function getProductId(): int;
 }
