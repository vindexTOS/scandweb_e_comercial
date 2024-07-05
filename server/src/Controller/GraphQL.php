<?php

namespace App\Controller;
 use PDO;
 
use Throwable;
use RuntimeException;
use GraphQL\Type\Schema;
 
use GraphQL\Type\SchemaConfig;
 use GraphQL\Type\Definition\Type;
use App\Resolvers\PriceResolver;
use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Type\Definition\ObjectType;

class GraphQL {
 
             
        private  $priceResolver;      
     public function __construct(PriceResolver $priceResolver){
        $this->priceResolver = $priceResolver;
     }



     public function getTest(){
        return $this->priceResolver->getPrices();
    }

    static public function handle() {

        try {
            // Define Currency Type
            $currencyType = new ObjectType([
                'name' => 'Currency',
                'fields' => [
                    'id' => Type::nonNull(Type::id()),
                    'label' => Type::nonNull(Type::string()),
                    'symbol' => Type::nonNull(Type::string()),
                ],
            ]);
            
            
      
            $priceType = new ObjectType([
                'name' => 'Price',
                'fields' => [
                    'id' => Type::nonNull(Type::id()),
                    'amount' => Type::nonNull(Type::float()),
                    'currency' => Type::nonNull(Type::int()),
                    'product_id' => Type::nonNull(Type::int()),
                ],
            ]);

            // Define Query Type
            $queryType = new ObjectType([
                'name' => 'Query',
                'fields' => [
                    'getPrices' => [
                        'type' => Type::listOf($priceType),
                        'resolve' => function ($root, $args, $context, $info) {
                            try {
                                  
                                return $this->priceResolver->getPrices();
                            } catch (Throwable $e) {
                                error_log($e->getMessage());
                                return null;
                            }
                        },
                    ],
                ],
            ]);
            // Define Mutation Type
            $mutationType = new ObjectType([
                'name' => 'Mutation',
                'fields' => [
                    'sum' => [
                        'type' => Type::int(),
                        'args' => [
                            'x' => ['type' => Type::int()],
                            'y' => ['type' => Type::int()],
                        ],
                        'resolve' => static fn ($calc, array $args): int => $args['x'] + $args['y'],
                    ],
                    'createCurrency' => [
                        'type' => $currencyType,
                        'args' => [
                            'label' => Type::nonNull(Type::string()),
                            'symbol' => Type::nonNull(Type::string()),
                        ],
                        'resolve' => static function ($rootValue, array $args) {
                            // Implement the logic to save the currency to the database
                            $db = new PDO("mysql:host=localhost;dbname=scandweb", "root", "");
                            $stmt = $db->prepare("INSERT INTO currencies (label, symbol) VALUES (:label, :symbol)");
                            $stmt->bindParam(':label', $args['label']);
                            $stmt->bindParam(':symbol', $args['symbol']);
                            $stmt->execute();
                            
                            $currencyId = $db->lastInsertId();
                            
                            return [
                                'id' => $currencyId,
                                'label' => $args['label'],
                                'symbol' => $args['symbol'],
                            ];
                        },
                    ],
                    "createPrice"=>[
                        "type"=>$priceType ,
                        "args"=>[
                            'amount' => Type::nonNull(Type::int()),
                            "currency" => Type::nonNull(Type::int()),
                            "product_id" => Type::nonNull(Type::int())
                        ],
                        "resolve"=> static function ($rootValue, array $args){
                            $db = new PDO("mysql:host=localhost;dbname=scandweb", "root", "");
                            $stmt = $db->prepare("INSERT INTO price (amount, currency,product_id) VALUES (:amount, :currency, :product_id)");
                            $stmt->bindParam(':label', $args['label']);
                            $stmt->bindParam(':symbol', $args['symbol']);
                            $stmt->execute();
                            
                            $currencyId = $db->lastInsertId();
                        }
                        ]
                    ],
                ]);

                
                // Create the Schema
                $schema = new Schema(
                    (new SchemaConfig())
                    ->setQuery($queryType)
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
                $result = GraphQLBase::executeQuery($schema, $query, $rootValue, null, $variableValues);
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
    }