<?php

namespace App\Resolvers;

use Error;
use App\Database\DatabaseContext;
use App\Models\Order\Order;

class PlaceOrderResolver {
    private DatabaseContext $dbContext;

    public function __construct(DatabaseContext $dbContext){
        $this->dbContext = $dbContext;
    }

    public function makeOrder(array $orderInput, array $attributesInput) {
        try {
            // Step 1: Create the order
            $orderId = Order::createOrder($this->dbContext, $orderInput);
            if (!$orderId) {
                throw new Error('Order creation failed.');
            }

            // Step 2: Create order attributes
            foreach ($attributesInput as $attributeInput) {
                $attributeInput['order_id'] = $orderId; // Associate attribute with the created order
                Order::createOrderAttribute($this->dbContext, $attributeInput);
            }

            // Step 3: Fetch the newly created order with attributes
            $order = Order::getOrderById($this->dbContext, $orderId);
            if (!$order) {
                throw new Error('Order not found after creation.');
            }

            // Fetch attributes related to the created order
            $attributes = Order::getOrderAttributesByOrderId($this->dbContext, $orderId);

            // Return the order with its attributes
            return [
                'order' => [
                    'id' => $order->getId(),
                    'product_id' => $order->getProductId(),
                    'attributes' => $attributes,
                ],
            ];
        } catch (\Throwable $e) {
            error_log('Error in resolver: ' . $e->getMessage());
            throw new Error('Failed to create order: ' . $e->getMessage());
        }
    }
}
