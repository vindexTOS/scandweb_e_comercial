<?php 
namespace App\Models\Attribute;

interface AttributeInterface {
    public function getId(): int;
    public function getName(): string;
    public function getType(): string;
}