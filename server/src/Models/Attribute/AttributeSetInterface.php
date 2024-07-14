<?php 

namespace App\Models\Attribute;

interface AttributeSetInterface {
    public function getId(): int;
    public function getDisplayValue(): string;
    public function getValue(): string;
    public function toArray(): array;
}