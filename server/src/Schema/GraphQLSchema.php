<?php 

namespace App\Schema;

use App\Types\GraphQLTypes;
use App\Resolvers\PriceResolver;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;




class GraphQLSchema { 
    public static function build(): \GraphQL\Type\Schema
    {
        $queryType = self::getQueryType();
        
        
        return new \GraphQL\Type\Schema([
            'query' => $queryType,
            
        ]);
    }
    
    private static function getQueryType(): ObjectType
    {
        return new ObjectType([
            'name' => 'Query',
            'fields' => [
                'getPrices' => [
                    'type' => Type::listOf(GraphQLTypes::getPriceType()),
                    'resolve' => function ($root, $args, $context, $info) {
                        return [PriceResolver::class, 'getPrices'];
                    },
                ],
            ],
        ]);
    }
}