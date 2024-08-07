<?php 

namespace App\Types;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\InputObjectType;

class GraphQLTypes {
    private static $objectTypes = [];
    private static $inputTypes = [];

     protected function getObjectType(string $typeName, callable $creator): ObjectType {
        if (!isset(self::$objectTypes[$typeName])) {
            self::$objectTypes[$typeName] = $creator();
        }
        return self::$objectTypes[$typeName];
    }

     protected function getInputType(string $typeName, callable $creator): InputObjectType {
        if (!isset(self::$inputTypes[$typeName])) {
            self::$inputTypes[$typeName] = $creator();
        }
        return self::$inputTypes[$typeName];
    }

    protected function getPriceType(): ObjectType {
        return $this->getObjectType('Price', function() {
            return new ObjectType([
                'name' => 'Price',
                'fields' => [
                    'id' => Type::nonNull(Type::id()),
                    'amount' => Type::nonNull(Type::float()),
                    'product_id' => Type::nonNull(Type::int()),
                    'currency' => $this->getCurrencyType(),
                ],
            ]);
        });
    }

    protected function getProductType(): ObjectType {
        return $this->getObjectType('Product', function() {
            return new ObjectType([
                'name' => 'Product',
                'fields' => [
                    'id' => Type::nonNull(Type::id()),
                    'product_id'=>Type::nonNull(Type::id()),
                    'name' => Type::nonNull(Type::string()),
                    'inStock' => Type::nonNull(Type::boolean()),
                    'gallery' => Type::listOf(Type::nonNull(Type::string())),
                    'description' => Type::nonNull(Type::string()),
                    'attributes' => Type::listOf($this->getAttributeType()),
                    'category' => Type::nonNull(Type::string()),
                    'prices' => Type::listOf($this->getPriceType()),
                    'brand' => Type::nonNull(Type::string())
                ],
            ]);
        });
    }

    protected function getAttributeType(): ObjectType {
        return $this->getObjectType('Attribute', function() {
            return new ObjectType([
                'name' => 'Attribute',
                'fields' => [
                    'id' => Type::nonNull(Type::string()),
                    'name' => Type::nonNull(Type::string()),
                    'type' => Type::nonNull(Type::string()),
                    'items' => Type::listOf($this->getAttributeSetType()),
                ],
            ]);
        });
    }

    protected function getAttributeSetType(): ObjectType {
        return $this->getObjectType('AttributeSet', function() {
            return new ObjectType([
                'name' => 'AttributeSet',
                'fields' => [
                    'id' => Type::nonNull(Type::id()),
                    'displayValue' => Type::nonNull(Type::string()),
                    'value' => Type::nonNull(Type::string()),
                ],
            ]);
        });
    }

    protected function getCurrencyType(): ObjectType {
        return $this->getObjectType('Currency', function() {
            return new ObjectType([
                'name' => 'Currency',
                'fields' => [
                    'id' => Type::nonNull(Type::id()),
                    'label' => Type::nonNull(Type::string()),
                    'symbol' => Type::nonNull(Type::string()),
                ],
            ]);
        });
    }

    protected function getCategoryType(): ObjectType {
        return $this->getObjectType('Category', function() {
            return new ObjectType([
                'name' => 'Category',
                'fields' => [
                    'name' => Type::nonNull(Type::string()),
                    'id' => Type::nonNull(Type::id()),
                ],
            ]);
        });
    }

    protected function getCreateOrderResultType(): ObjectType {
        return $this->getObjectType('CreateOrderResult', function() {
            return new ObjectType([
                'name' => 'CreateOrderResult',
                'fields' => [
                    'order' => $this->getOrderType(),
                ],
            ]);
        });
    }

    protected function getOrderType(): ObjectType {
        return $this->getObjectType('Order', function() {
            return new ObjectType([
                'name' => 'Order',
                'fields' => [
                    'id' => Type::nonNull(Type::id()),
                    'product_id' => Type::nonNull(Type::int()),
                    'attributes' => Type::listOf($this->getOrderAttributeType()),
                ],
            ]);
        });
    }

    protected function getOrderInputType(): InputObjectType {
        return $this->getInputType('OrderInput', function() {
            return new InputObjectType([
                'name' => 'OrderInput',
                'fields' => [
                    'product_id' => Type::nonNull(Type::int()),
                ],
            ]);
        });
    }

    protected function getOrderAttributeInputType(): InputObjectType {
        return $this->getInputType('OrderAttributeInput', function() {
            return new InputObjectType([
                'name' => 'OrderAttributeInput',
                'fields' => [
                    'key' => Type::nonNull(Type::string()),
                    'value' => Type::nonNull(Type::string()),
                ],
            ]);
        });
    }

    protected function getOrderAttributeType(): ObjectType {
        return $this->getObjectType('OrderAttribute', function() {
            return new ObjectType([
                'name' => 'OrderAttribute',
                'fields' => [
                    'key' => Type::nonNull(Type::string()),
                    'value' => Type::nonNull(Type::string()),
                ],
            ]);
        });
    }
}
