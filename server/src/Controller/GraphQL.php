<?php

namespace App\Controller;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\GraphQL as GraphQLBase;
use RuntimeException;
use Throwable;

class GraphQL {
    public static function handle() {
        try {
            // Define the GraphQL types
            $currencyType = new ObjectType([
                'name' => 'Currency',
                'fields' => [
                    'label' => Type::string(),
                    'symbol' => Type::string(),
                ],
            ]);
            
            $priceType = new ObjectType([
                'name' => 'Price',
                'fields' => [
                    'amount' => Type::float(),
                    'currency' => $currencyType,
                ],
            ]);
            
            $attributeType = new ObjectType([
                'name' => 'Attribute',
                'fields' => [
                    'id' => Type::string(),
                    'displayValue' => Type::string(),
                    'value' => Type::string(),
                ],
            ]);
            
            $attributeSetType = new ObjectType([
                'name' => 'AttributeSet',
                'fields' => [
                    'id' => Type::string(),
                    'name' => Type::string(),
                    'type' => Type::string(),
                    'items' => Type::listOf($attributeType),
                ],
            ]);
            
            $categoryType = new ObjectType([
                'name' => 'Category',
                'fields' => [
                    'id' => Type::int(),
                    'name' => Type::string(),
                ],
            ]);
            
            $productType = new ObjectType([
                'name' => 'Product',
                'fields' => [
                    'id' => Type::string(),
                    'name' => Type::string(),
                    'inStock' => Type::boolean(),
                    'gallery' => Type::listOf(Type::string()),
                    'description' => Type::string(),
                    'category' => Type::string(),
                    'attributes' => Type::listOf($attributeSetType),
                    'prices' => Type::listOf($priceType),
                    'brand' => Type::string(),
                ],
            ]);
            
            $queryType = new ObjectType([
                'name' => 'Query',
                'fields' => [
                    'categories' => [
                        'type' => Type::listOf($categoryType),
                        'resolve' => function() {
                            return self::fetchCategories();
                        },
                    ],
                    'products' => [
                        'type' => Type::listOf($productType),
                        'resolve' => function() {
                            return self::fetchProducts();
                        },
                    ],
                ],
            ]);
            
            $mutationType = new ObjectType([
                'name' => 'Mutation',
                'fields' => [
                    'addCategory' => [
                        'type' => $categoryType,
                        'args' => [
                            'name' => Type::nonNull(Type::string()),
                        ],
                        'resolve' => function($root, $args) {
                            return self::addCategory($args['name']);
                        },
                    ],
                    'addProduct' => [
                        'type' => $productType,
                        'args' => [
                            'name' => Type::nonNull(Type::string()),
                            'inStock' => Type::nonNull(Type::boolean()),
                            'gallery' => Type::listOf(Type::string()),
                            'description' => Type::string(),
                            'category' => Type::nonNull(Type::string()),
                            'attributes' => Type::listOf($attributeSetType),
                            'prices' => Type::listOf($priceType),
                            'brand' => Type::string(),
                        ],
                        'resolve' => function($root, $args) {
                            return self::addProduct($args);
                        },
                    ],
                ],
            ]);
            
            $schema = new Schema([
                'query' => $queryType,
                'mutation' => $mutationType,
            ]);
            
            $rawInput = file_get_contents('php://input');
            if ($rawInput === false) {
                throw new RuntimeException('Failed to get php://input');
            }
            
            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variableValues = $input['variables'] ?? null;
            
            $result = GraphQLBase::executeQuery($schema, $query, null, null, $variableValues);
            $output = $result->toArray();
        } catch (Throwable $e) {
            $output = [
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ];
        }
        
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($output);
    }
    
    private static function fetchCategories() {
        return [
            ['id' => 1, 'name' => 'all'],
            ['id' => 2, 'name' => 'clothes'],
            ['id' => 3, 'name' => 'tech'],
        ];
    }
    
    private static function fetchProducts() {
        return [
            [
                'id' => 'huarache-x-stussy-le',
                'name' => 'Nike Air Huarache Le',
                'inStock' => true,
                'gallery' => [
                    "https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_2_720x.jpg?v=1612816087",
                ],
                'description' => '<p>Great sneakers for everyday use!</p>',
                'category' => 'clothes',
                'attributes' => [
                    [
                        'id' => 'Size',
                        'name' => 'Size',
                        'type' => 'text',
                        'items' => [
                            ['id' => '40', 'displayValue' => '40', 'value' => '40'],
                            
                        ],
                    ],
                ],
                'prices' => [
                    ['amount' => 144.69, 'currency' => ['label' => 'USD', 'symbol' => '$']],
                ],
                'brand' => 'Nike x Stussy',
            ],
            
        ];
    }
    
    private static function addCategory($name) {
        $newCategory = ['id' => rand(4, 1000), 'name' => $name];
        return $newCategory;
    }
    
    private static function addProduct($args) {
        $newProduct = [
            'id' => uniqid(),
            'name' => $args['name'],
            'inStock' => $args['inStock'],
            'gallery' => $args['gallery'],
            'description' => $args['description'],
            'category' => $args['category'],
            'attributes' => $args['attributes'],
            'prices' => $args['prices'],
            'brand' => $args['brand'],
        ];
        return $newProduct;
    }
}