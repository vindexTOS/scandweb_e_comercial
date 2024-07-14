<?php

namespace App\Models\Price;

use App\Models\Currency\Currency;
use App\Database\DatabaseContext;
use PDOException;
use RuntimeException;

abstract class AbstractPrice implements PriceInterface {
    protected int $id;
    protected float $amount;
    protected Currency $currency;

    public function __construct(int $id, float $amount, Currency $currency) {
        $this->id = $id;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    abstract public function toArray(): array;

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
                $currency = new Currency($priceData['currency_label'], $priceData['currency_symbol']);
                $prices[] = new static($priceData['id'], $priceData['amount'], $currency);
            }

            return $prices;
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch prices: " . $e->getMessage());
        }
    }
}