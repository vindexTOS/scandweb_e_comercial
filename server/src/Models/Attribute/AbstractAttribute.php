<?php 
namespace App\Models\Attribute;


use PDOException;
use RuntimeException;
use App\Database\DatabaseContext;

abstract class AbstractAttribute implements AttributeInterface {
    protected int $id;
    protected string $name;
    protected string $type;

    public function __construct(int $id, string $name, string $type) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
    }

    public static function getAttributes(DatabaseContext $dbContext, int $productId): ?array {
        try {
            $query = "SELECT * FROM attribute WHERE product_id = :productId;";
            $attributes = $dbContext->getAll($query, [':productId' => $productId]);

            $result = [];

            foreach ($attributes as $attribute) {
                $items = [];
                $item = AttributeSet::getAttributeSet($dbContext, $attribute['id']);

                foreach ($item as $ite) {
                    $items[] = $ite->toArray();
                }

                $result[] = [
                    'id' => $attribute['type'],
                    'items' => $items,
                    'name' => $attribute['name'],
                    'type' => $attribute['type'],
                    '__typename' => 'AttributeSet'
                ];
            }
            if (!$attributes) {
                return null;
            }

            return $result;
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch attributes: " . $e->getMessage());
        }
    }

    abstract public function getId(): int;
    abstract public function getName(): string;
    abstract public function getType(): string;
}