<?php
namespace App\Controller;

use Throwable;
use RuntimeException;
use GraphQL\Type\Schema;
use App\Types\GraphQLTypes;
use GraphQL\Type\SchemaConfig;
use App\Resolvers\PriceResolver;
use GraphQL\Type\Definition\Type;
use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Type\Definition\ObjectType;

class GraphQL {
    private $priceResolver;
    
    public function __construct(PriceResolver $priceResolver) {
        $this->priceResolver = $priceResolver;
    }
    
    public function getTest() {
        return $this->priceResolver->getPrices();
    }
    
    public function handle() {
        try {
            
            
            // Define Query Type
            $queryType = new ObjectType([
                'name' => 'Query',
                'fields' => [
                    'getPrices' => [
                        'type' => Type::listOf(GraphQLTypes::getPriceType()),
                        'resolve' => function ($root, $args, $context, $info) {
                            try {
                                return $context['priceResolver']->getPrices();
                            } catch (Throwable $e) {
                                error_log('Error in resolver: ' . $e->getMessage());
                                return null;
                            }
                        },
                    ],
                ],
            ]);
            
            // Create the Schema
            $schema = new Schema(
                (new SchemaConfig())->setQuery($queryType)
            );
            
            // Handle the GraphQL request
            $rawInput = file_get_contents('php://input');
            if ($rawInput === false) {
                throw new RuntimeException('Failed to get php://input');
            }
            
            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variableValues = $input['variables'] ?? null;
            
            $rootValue = ['prefix' => 'You said: '];
            $context = ['priceResolver' => $this->priceResolver];
            $result = GraphQLBase::executeQuery($schema, $query, $rootValue, $context, $variableValues);
            $output = $result->toArray();
        } catch (Throwable $e) {
            error_log('Error handling GraphQL request: ' . $e->getMessage());
            $output = [
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ];
        }
        
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($output);
    }
}