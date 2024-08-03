<?php
namespace App\Controller;

use Error;
use Throwable;
use RuntimeException;
use GraphQL\Type\Schema;
use App\Types\GraphQLTypes;
use GraphQL\Type\Definition\Type;
use GraphQL\GraphQL as GraphQLBase;
use App\Resolvers\ProductResolver;
use App\Resolvers\CategoriesResolver;
use App\Resolvers\PlaceOrderResolver;
use App\Schema\GraphQLSchema;

class GraphQL extends GraphQLSchema
{
    private $productResolver;
    private $categoriesResolver;
    private $placeOrderResolver;

    public function __construct(ProductResolver $productResolver, CategoriesResolver $categoriesResolver, PlaceOrderResolver $placeOrderResolver)
    {
        $this->productResolver = $productResolver;
        $this->categoriesResolver = $categoriesResolver;
        $this->placeOrderResolver = $placeOrderResolver;
    }

    public function getTest($request)
    {
        try {
            // Example of getting categories with a request
            return $this->categoriesResolver->getCategories();
        } catch (\Exception $e) {
            error_log('Error fetching categories: ' . $e->getMessage());
            throw new Error('Failed to fetch categories: ' . $e->getMessage());
        }
    }

    public function handle()
    {
        try {
            // Initialize schema with both query and mutation types
            $schema = new Schema([
                'query' => $this->getQueryType(),
                'mutation' => $this->getMutationType(),
            ]);
    
            // Debug: Print registered types
            foreach ($schema->getTypeMap() as $typeName => $type) {
                error_log("Type Name: $typeName");
            }
    
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
                'categoriesResolver' => $this->categoriesResolver,
                'placeOrderResolver' => $this->placeOrderResolver,
            ];
    
            $result = GraphQLBase::executeQuery($schema, $query, $rootValue, $context, $variableValues);
            $output = $result->toArray();
        } catch (Throwable $e) {
            error_log('Error handling GraphQL request: ' . $e->getMessage());
            $output = [
                'errors' => [
                    [
                        'message' => $e->getMessage(),
                    ],
                ],
            ];
        }
    
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($output);
    }
}