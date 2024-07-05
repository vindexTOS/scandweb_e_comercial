<?php 




namespace App\Types;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;



class GraphQLTypes { 
    
    public static function getPriceType(): ObjectType {
        return new ObjectType([
            'name' => 'Price',
            'fields' => [
                'id' => Type::nonNull(Type::id()),
                'amount' => Type::nonNull(Type::float()),
                'product_id' => Type::nonNull(Type::int()),
                'currency_label' => Type::nonNull(Type::string()),
                'currency_symbol' => Type::nonNull(Type::string()),
                'currency_id' => Type::nonNull(Type::int()),
            ],
        ]);
    }
    
    public static function getCurrency():ObjectType {
        
        return new ObjectType([
            'name' => 'Price',
            'fields' => [
                'id' => Type::nonNull(Type::id()),
                'label' => Type::nonNull(Type::string()),
                'symbol' => Type::nonNull(Type::string()),
                
            ],
        ]);
    }
    
}