<?php
namespace App\Models\Attribute;

class AttributeSet extends AbstractAttributeSet {
    public function __construct(int $id, string $displayValue, string $value) {
        parent::__construct($id, $displayValue, $value);
    }

    public function getId(): int {
        return $this->id;
    }

    public function getDisplayValue(): string {
        return $this->displayValue;
    }

    public function getValue(): string {
        return $this->value;
    }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "displayValue" => $this->displayValue,
            "value" => $this->value,
        ];
    }
}