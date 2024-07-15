<?php
namespace App\Controller;

use Error;
use Throwable;
use RuntimeException;
use GraphQL\Type\Schema;
use App\Types\GraphQLTypes;
use GraphQL\Type\SchemaConfig;

use GraphQL\Type\Definition\Type;
use App\Resolvers\ProductResolver;
use GraphQL\GraphQL as GraphQLBase;
use App\Resolvers\CategoriesResolver;
use App\Schema\GraphQLSchema;
use GraphQL\Type\Definition\ObjectType;

class GraphQL extends GraphQLSchema {
    private $productResolver;
    private $categoriesReslover; 
    public function __construct(ProductResolver $productResolver,CategoriesResolver $categoriesReslover) {
        $this->productResolver =$productResolver;
        $this->categoriesReslover = $categoriesReslover;
    }
    
    public function getTest() {
        try {
            // return $this->productResolver->getProducts();
            return $this->categoriesReslover->getCategories();
        } catch (\Exception $e) {
            var_dump($e);
            echo "ERROR 500";
            throw new Error('Failed to fetch prices: ' . $e->getMessage());
            
        }
    }
    
    public function handle() {
        try {
            
            
            
            
            $schema = new Schema([
                'query' =>  $this->getQueryType(  ),
            ]);
            
            // Handle the GraphQL request
            $rawInput = file_get_contents('php://input');
            if ($rawInput === false) {
                throw new RuntimeException('Failed to get php://input');
            }
            
            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variableValues = $input['variables'] ?? null;
            
            $rootValue = ['prefix' => 'You said: '];
            $context = [
                'productResolver' => $this->productResolver,
                'categoriesReslover' => $this->categoriesReslover,
            ];            $result = GraphQLBase::executeQuery($schema, $query, $rootValue, $context, $variableValues);
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