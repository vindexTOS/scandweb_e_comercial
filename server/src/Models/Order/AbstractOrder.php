<?php 
 

namespace App\Models\Order;

use App\Database\DatabaseContext;
use PDOException;
use RuntimeException;

abstract class AbstractOrder implements OrderInterface {
    protected int $id;
    protected int $product_id;

    public function __construct(int $id, int $product_id) {
        $this->id = $id;
        $this->product_id = $product_id;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getProductId(): int {
        return $this->product_id;
    }

    public static function createOrder(DatabaseContext $dbContext, array $orderInput): ?int {
        try {
            $query = "INSERT INTO orders (product_id) VALUES (:product_id)";
            $params = [':product_id' => $orderInput['product_id']];
            return $dbContext->createSingle($query, $params);
        } catch (\Throwable $th) {
            error_log('Error creating order: ' . $th->getMessage());
            throw new RuntimeException("Failed to create order: " . $th->getMessage());
        }
    }

    public static function getAllOrders(DatabaseContext $dbContext): array {
        try {
            $query = "SELECT * FROM orders";
            $orderData = $dbContext->getAll($query);

            $orders = [];
            foreach ($orderData as $data) {
                $orders[] = new static($data['id'], $data['product_id']);
            }

            return $orders;
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch orders: " . $e->getMessage());
        }
    }

    public static function getOrderById(DatabaseContext $dbContext, int $id): ?AbstractOrder {
        try {
            $query = "SELECT * FROM orders WHERE id = :id";
            $orderData = $dbContext->getSingle($query, [':id' => $id]);

            if ($orderData) {
                return new static($orderData['id'], $orderData['product_id']);
            }
            
            return null;
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch order by ID: " . $e->getMessage());
        }
    }

    public static function createOrderAttribute(DatabaseContext $dbContext, array $attributeInput): void {
        try {
            $query = "INSERT INTO order_attribute (`key`, value, order_id) VALUES (:key, :value, :order_id)";
            $params = [
                ':key' => $attributeInput['key'],
                ':value' => $attributeInput['value'],
                ':order_id' => $attributeInput['order_id']
            ];
            $dbContext->createSingle($query, $params);
        } catch (\Throwable $th) {
            error_log('Error creating order attribute: ' . $th->getMessage());
            throw new RuntimeException("Failed to create order attribute: " . $th->getMessage());
        }
    }

    public static function getOrderAttributesByOrderId(DatabaseContext $dbContext, int $orderId): array {
        try {
            $query = "SELECT * FROM order_attribute WHERE order_id = :order_id";
            $attributesData = $dbContext->getAll($query, [':order_id' => $orderId]);

            $attributes = [];
            foreach ($attributesData as $data) {
                $attributes[] = $data;
            }

            return $attributes;
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch order attributes: " . $e->getMessage());
        }
    }
}
