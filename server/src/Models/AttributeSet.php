<?php
namespace App\Models;


class AttributeSet
{
    private int $id;
    private string $name;
    private string $type;
    private array $items;
    
    public function __construct(int $id, string $name, string $type, array $items)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->items = $items;
    }
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function getType(): string
    {
        return $this->type;
    }
    
    public function getItems(): array
    {
        return $this->items;
    }
}