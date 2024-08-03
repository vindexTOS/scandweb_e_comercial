<?php
namespace App\Schema;

use Throwable;
use GraphQL\Error\Error;
use App\Types\GraphQLTypes;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\InputObjectType;

class GraphQLSchema extends GraphQLTypes
{
    public static function build(): \GraphQL\Type\Schema
    {
        $queryType = self::getQueryType();
        $mutationType = self::getMutationType();

        return new \GraphQL\Type\Schema([
            'query' => $queryType,
            'mutation' => $mutationType,
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
                            return $context['productResolver']->getProducts($category);
                        } catch (Throwable $e) {
                            error_log('Error in resolver: ' . $e->getMessage());
                            return null;
                        }
                    },
                ],
                // 'singleProduct' => [
                //     'args' => [
                //         'id' => ['type' => Type::string()],
                //     ],
                //     'type' => $this->getProductType(),
                //     'resolve' => function ($root, $args, $context, $info) {
                //         try {
                //             $id = $args["id"];
                //             error_log('GraphQL Resolver called with ID: ' . $id);
                //             $result = $context['productResolver']->getProduct($id);
                //             error_log('Resolver result: ' . print_r($result, true));
                //             return $result;
                //         } catch (Throwable $e) {
                //             error_log('GraphQL Resolver error: ' . $e->getMessage());
                //             return null;
                //         }
                //     },
                // ],
                'categories' => [
                    'type' => Type::listOf($this->getCategoryType()),
                    'resolve' => function ($root, $args, $context, $info) {
                        try {
                            return $context['categoriesResolver']->getCategories();
                        } catch (Throwable $e) {
                            error_log('Error in resolver: ' . $e->getMessage());
                            return null;
                        }
                    },
                ],
            ],
        ]);
    }
    protected function getMutationType(): ObjectType
    {
        return new ObjectType([
            'name' => 'Mutation',
            'fields' => [
                'createOrder' => [
                    'type' => $this->getCreateOrderResultType(),
                    'args' => [
                        'orderInput' => [
                            'type' => Type::nonNull($this->getOrderInputType()),
                        ],
                        'attributesInput' => [
                            'type' => Type::listOf($this->getOrderAttributeInputType()),
                        ],
                    ],
                    'resolve' => function ($root, $args, $context, $info) {
                        try {
                            // Use the resolver method to handle the mutation logic
                            $orderResolver = $context['placeOrderResolver'];
                            $result = $orderResolver->makeOrder($args['orderInput'], $args['attributesInput']);
                            
                            if (!$result) {
                                throw new Error('Order creation failed.');
                            }

                            return $result;
                        } catch (\Throwable $e) {
                            error_log('Error in resolver: ' . $e->getMessage());
                            throw new Error('Failed to create order: ' . $e->getMessage());
                        }
                    },
                ],
            ],
        ]);
    }
    
}