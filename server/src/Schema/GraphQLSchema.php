<?php

namespace App\Schema;

use Throwable;
use App\Types\GraphQLTypes;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class GraphQLSchema extends GraphQLTypes
{
    public static function build(): \GraphQL\Type\Schema
    {
        $queryType = self::getQueryType();

        return new \GraphQL\Type\Schema([
            'query' => $queryType,
        ]);
    }

    protected function getQueryType(): ObjectType
    {
        return new ObjectType([
            'name' => 'Query',
            'fields' => [
                'products' => [
                    'args' => [
                        'category' => ['type' => Type::string()],
                    ],
                    'type' => Type::listOf($this->getProductType()),
                    'resolve' => function ($root, $args, $context, $info) {
                        try {
                            $category = isset($args['category']) ? (string) $args['category'] : null;

                            return $context['productResolver']->getProducts($args['category']);
                        } catch (Throwable $e) {
                            error_log('Error in resolver: ' . $e->getMessage());
                            return null;
                        }
                    },
                ],

                'singleProduct' => [
                    'args' => [
                        'id' => ['type' => Type::string()],
                    ],
                    'type' => $this->getProductType(),
                    'resolve' => function ($root, $args, $context, $info) {
                        try {
                            $id = $args["id"];
                            error_log('GraphQL Resolver called with ID: ' . $id);
                            $result = $context['productResolver']->getProduct($id);
                            error_log('Resolver result: ' . print_r($result, true));
                            return $result;
                        } catch (Throwable $e) {
                            error_log('GraphQL Resolver error: ' . $e->getMessage());
                            return null;
                        }
                    },
                ],
                "categories" => [
                    "type" => Type::listOf($this->getCategoryType()),
                    "resolve" => function ($root, $args, $context, $info) {
                        try {
                            return $context['categoriesReslover']->getCategories();
                        } catch (Throwable $e) {
                            error_log('Error in resolver: ' . $e->getMessage());
                            return null;
                        }
                    }
                ]
            ],
        ]);
    }
}
