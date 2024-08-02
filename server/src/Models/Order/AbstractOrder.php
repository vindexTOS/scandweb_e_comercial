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
}