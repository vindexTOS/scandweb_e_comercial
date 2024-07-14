<?php 
namespace App\Models\Attribute;

use App\Database\DatabaseContext;
use App\Models\Attribute\AttributeSet;

class Attribute extends AbstractAttribute {
    public function __construct(int $id, string $name, string $type) {
        parent::__construct($id, $name, $type);
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getType(): string {
        return $this->type;
    }
}