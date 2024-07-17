<?php 

namespace App\Schema;

use Throwable;
use App\Types\GraphQLTypes;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class GraphQLSchema extends GraphQLTypes { 
    public static function build(): \GraphQL\Type\Schema {
        $queryType = self::getQueryType();
        
        return new \GraphQL\Type\Schema([
            'query' => $queryType,
        ]);
    }
    
    protected function getQueryType(): ObjectType {
        return new ObjectType([
            'name' => 'Query',
            'fields' => [
                'products' => [
                    'type' => Type::listOf($this->getProductType()),
                    'resolve' => function ($root, $args, $context, $info) {
                        try {
                            return $context['productResolver']->getProducts();
                        } catch (Throwable $e) {
                            error_log('Error in resolver: ' . $e->getMessage());
                            return null;
                        }
                    },
                ],
                
                "categories" => [ 
                    "type"=> Type::listOf($this->getCategoryType()),
                    "resolve"=> function ($root,$args,$context,$info){
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