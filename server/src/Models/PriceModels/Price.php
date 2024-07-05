<?php

namespace App\Models\PriceModels;

use PDOException;
use RuntimeException;
use App\Models\Currency;
use App\Database\DatabaseContext;

class Price 
{
    private float $amount;
    private Currency $currency;
    private int $product_id;
    
    
    
    
    
    
    
    public function __construct(float $amount, Currency $currency, int $product_id)
    {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->product_id = $product_id;
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