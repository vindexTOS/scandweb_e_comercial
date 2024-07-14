<?php 


namespace App\Types;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class GraphQLTypes { 
    public static function getPriceType(): ObjectType {
        return new ObjectType([
            'name' => 'Price',
            'fields' => [
                'id' => Type::nonNull(Type::id()),
                'amount' => Type::nonNull(Type::float()),
                'product_id' => Type::nonNull(Type::int()),
                'currency' => [
                    'type' => GraphQLTypes::getCurrency(),
                    'resolve' => function($root, $args, $context, $info) {
                         return $root['currency'];  
                    }
                ]
            ],
        ]);
    }

    public static function getProductType(): ObjectType {
        return new ObjectType([
            'name' => 'Product',
            'fields' => [
                'id' => Type::nonNull(Type::id()),
                'name' => Type::nonNull(Type::string()),
                'inStock' => Type::nonNull(Type::boolean()),
                'gallery' => Type::listOf(Type::nonNull(Type::string())),
                'description' => Type::nonNull(Type::string()),
                // 'attributes' => Type::listOf(GraphQLTypes::getAttributeType()),
                'category' => Type::nonNull(Type::string()),
                'prices' => Type::listOf(GraphQLTypes::getPriceType()),
                'brand' => Type::nonNull(Type::string())
            ]
        ]);
    }

    public static function getAttributeType(): ObjectType {
        return new ObjectType([
            'name' => 'Attribute',
            'fields' => [
                'id' => Type::nonNull(Type::id()),
                'name' => Type::nonNull(Type::string()),
                'type' => Type::nonNull(Type::string()),
                'items' => Type::listOf(GraphQLTypes::getAttributeSetType()),
                '__typename' => Type::nonNull(Type::string())
            ]
        ]);
    }

    public static function getAttributeSetType(): ObjectType {
        return new ObjectType([
            'name' => 'AttributeSet',
            'fields' => [
                'id' => Type::nonNull(Type::id()),
                'displayValue' => Type::nonNull(Type::string()),
                'value' => Type::nonNull(Type::string())
            ]
        ]);
    }

    public static function getCurrency(): ObjectType {
        return new ObjectType([
            'name' => 'Currency',
            'fields' => [
                'id' => Type::nonNull(Type::id()),
                'label' => Type::nonNull(Type::string()),
                'symbol' => Type::nonNull(Type::string()),
            ],
        ]);
    }
}