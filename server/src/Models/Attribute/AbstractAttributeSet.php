<?php

namespace App\Models\Attribute;

use PDOException;
use RuntimeException;
use App\Database\DatabaseContext;

abstract class AbstractAttributeSet implements AttributeSetInterface {
    protected int $id;
    protected string $displayValue;
    protected string $value;

    public function __construct(int $id, string $displayValue, string $value) {
        $this->id = $id;
        $this->displayValue = $displayValue;
        $this->value = $value;
    }

    public static function getAttributeSet(DatabaseContext $dbContext, int $attribute_id): array {
        try {
            $query = "SELECT * FROM attribute_set WHERE attribute_id = :attribute_id;";
            $attributeSetData = $dbContext->getAll($query, [":attribute_id" => $attribute_id]);

            $attributeSets = [];
            foreach ($attributeSetData as $data) {
                $attributeSets[] = new static($data['id'], $data['displayValue'], $data['value']);
            }

            return $attributeSets;
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch attribute_set: " . $e->getMessage());
        }
    }

    abstract public function getId(): int;
    abstract public function getDisplayValue(): string;
    abstract public function getValue(): string;
    abstract public function toArray(): array;
}