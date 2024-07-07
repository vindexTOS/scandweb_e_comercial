<?php

namespace App\Models\Price;

use PDOException;
use RuntimeException;
 use App\Database\DatabaseContext;
use App\Models\Currency\Currency;
class Price 
{
    private int $id;
    private float $amount;
    private Currency $currency;
     
    
    
    
    
    
    
    public function __construct(float $amount, Currency $currency, int $id )
    {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->id = $id;
     }
    
    
    
    public static function getAllPrices(DatabaseContext $dbContext): array {
        try {
            $query = "
            SELECT p.amount,p.id, p.product_id, c.id as currency_id, c.label as currency_label, c.symbol as currency_symbol
            FROM prices p
            LEFT JOIN currencies c ON p.currency = c.id
        ";
            $pricesData = $dbContext->getAll( $query);
            // $jsonPrices = json_encode( $pricesData);
            
            // // Output JSON
            // header('Content-Type: application/json');
            // echo $jsonPrices;
            return  $pricesData ;
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch prices: " . $e->getMessage());
        }
    }
    
    
    
    
    
    public function getAmount(): float
    {
        return $this->amount;
    }
    
    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}