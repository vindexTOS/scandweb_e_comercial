<?php 


namespace App\Types;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\InputObjectType;

class GraphQLTypes { 
    protected function getPriceType(): ObjectType {
        return new ObjectType([
            'name' => 'Price',
            'fields' => [
                'id' => Type::nonNull(Type::id()),
                'amount' => Type::nonNull(Type::float()),
                'product_id' => Type::nonNull(Type::int()),
                'currency' => [
                    'type' => $this->getCurrencyType(),
                    'resolve' => function($root, $args, $context, $info) {
                        return $root['currency'];  
                    }
                    ]
                ],
            ]);
        }
        
        protected  function getProductType(): ObjectType {
            return new ObjectType([
                'name' => 'Product',
                'fields' => [
                    'id' => Type::nonNull(Type::id()),
                    'name' => Type::nonNull(Type::string()),
                    'inStock' => Type::nonNull(Type::boolean()),
                    'gallery' => Type::listOf(Type::nonNull(Type::string())),
                    'description' => Type::nonNull(Type::string()),
                    'attributes' => Type::listOf($this->getAttributeType()),
                    'category' => Type::nonNull(Type::string()),
                    'prices' => Type::listOf($this->getPriceType()),
                    'brand' => Type::nonNull(Type::string())
                    ]
                ]);
            }
            
            
            
            protected  function getAttributeType(): ObjectType {
                return new ObjectType([
                    'name' => 'Attribute',
                    'fields' => [
                        'id' => Type::nonNull(Type::string()),
                        'name' => Type::nonNull(Type::string()),
                        'type' => Type::nonNull(Type::string()),
                        'items' => [
                            'type' => Type::listOf($this->getAttributeSetType()),
                            'resolve' => function ($root, $args, $context, $info) {
                                return $root['items'];
                            }
                        ],
                    ],
                ]);
            }
            protected  function getAttributeSetType(): ObjectType {
                return new ObjectType([
                    'name' => 'AttributeSet',
                    'fields' => [
                        'id' => Type::nonNull(Type::id()),
                        'displayValue' => Type::nonNull(Type::string()),
                        'value' => Type::nonNull(Type::string()),
                    ],
                ]);
            }
            
            protected function getCurrencyType(): ObjectType {
                return new ObjectType([
                    'name' => 'Currency',
                    'fields' => [
                        'id' => Type::nonNull(Type::id()),
                        'label' => Type::nonNull(Type::string()),
                        'symbol' => Type::nonNull(Type::string()),
                    ],
                ]);
            }
            
            
            protected function getCategoryType(): ObjectType {
                
                return new ObjectType([
                    
                    "name"=> "Categories",
                    'fields'=> [
                        "name"=> Type::nonNull(Type::string()),
                        "id" => Type::nonNull(Type::id())
                        ]
                    ]);
                }
                
                
                protected  function getCategorysAndProducts():ObjectType { 
                    
                    return new ObjectType([
                        "name"=>"all-data",
                        'fields'=>[
                            'categories' =>$this->getCategoryType(),
                            "products"=>$this->getProductType()
                            ] 
                        ]);
                    }
// mutations 
  // Define Order type for result
  protected function getCreateOrderResultType(): ObjectType
  {
      return new ObjectType([
          'name' => 'CreateOrderResult',
          'fields' => [
              'order' => [
                  'type' => $this->getOrderType(),
                  'resolve' => function($root, $args, $context, $info) {
                      return $root['order'];
                  }
              ],
          ],
      ]);
  }

  // Define Order type
  protected function getOrderType(): ObjectType
  {
      return new ObjectType([
          'name' => 'Order',
          'fields' => [
              'id' => Type::nonNull(Type::id()),
              'product_id' => Type::nonNull(Type::int()),
              'attributes' => [
                  'type' => Type::listOf($this->getOrderAttributeType()),
                  'resolve' => function($root, $args, $context, $info) {
                      return $root['attributes'];
                  }
              ],
          ],
      ]);
  }

  // Define OrderInput type
  protected function getOrderInputType(): InputObjectType
  {
      return new InputObjectType([
          'name' => 'OrderInput',
          'fields' => [
              'product_id' => Type::nonNull(Type::int()),
          ],
      ]);
  }

  // Define OrderAttributeInput type
  protected function getOrderAttributeInputType(): InputObjectType
  {
      return new InputObjectType([
          'name' => 'OrderAttributeInput',
          'fields' => [
              'key' => Type::nonNull(Type::string()),
              'value' => Type::nonNull(Type::string()),
          ],
      ]);
  }

  // Define OrderAttribute type
  protected function getOrderAttributeType(): ObjectType
  {
      return new ObjectType([
          'name' => 'OrderAttribute',
          'fields' => [
              'key' => Type::nonNull(Type::string()),
              'value' => Type::nonNull(Type::string()),
          ],
      ]);
  }


                }