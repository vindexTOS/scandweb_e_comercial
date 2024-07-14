<?php 

namespace App\Schema;

use Throwable;
use App\Types\GraphQLTypes;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class GraphQLSchema { 
    public static function build(): \GraphQL\Type\Schema {
        $queryType = self::getQueryType();

        return new \GraphQL\Type\Schema([
            'query' => $queryType,
        ]);
    }

    private static function getQueryType(): ObjectType {
        return new ObjectType([
            'name' => 'Query',
            'fields' => [
                'getProducts' => [
                    'type' => Type::listOf(GraphQLTypes::getProductType()),
                    'resolve' => function ($root, $args, $context, $info) {
                        try {
                            return $context['productResolver']->getProducts();
                        } catch (Throwable $e) {
                            error_log('Error in resolver: ' . $e->getMessage());
                            return null;
                        }
                    },
                ],
            ],
        ]);
    }
}