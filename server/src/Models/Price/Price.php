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
    
    
    
    public static function getAllPrices(DatabaseContext $dbContext, int $productId = null): array {
        try {
            $query = "
                SELECT 
                    p.amount,
                    p.id, 
                    p.product_id, 
                    c.id AS currency_id, 
                    c.label AS currency_label, 
                    c.symbol AS currency_symbol
                FROM prices p
                LEFT JOIN currencies c ON p.currency_id = c.id
                WHERE p.product_id = :productId
            ";
            $pricesData = $dbContext->getAll($query, [':productId' => $productId]);
            
            $prices = [];
            foreach ($pricesData as $priceData) {
                $currency = new Currency(  $priceData['currency_label'], $priceData['currency_symbol']);
                $prices[] = new Price($priceData['amount'], $currency, $priceData['product_id']);
            }
            
            return $prices;
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch prices: " . $e->getMessage());
        }
    }
    
}






