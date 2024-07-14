<?php 
namespace App\Models\Currency;

use PDOException;
use RuntimeException;
use App\Database\DatabaseContext;

abstract class AbstractCurrency implements CurrencyInterface {
    protected string $label;
    protected string $symbol;

    public function __construct(string $label, string $symbol) {
        $this->label = $label;
        $this->symbol = $symbol;
    }

    abstract public function toArray(): array;

    public static function getCurrency(DatabaseContext $dbContext, int $id = null) {
        try {
            $query = "SELECT * FROM currencies WHERE id = :id";
            $currencyData = $dbContext->getSingle($query, [":id" => $id]);

            if (!$currencyData) {
                return null;
            }

            return new static($currencyData['label'], $currencyData['symbol']);
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch currency: " . $e->getMessage());
        }
    }

    public static function getAllCurrencies(DatabaseContext $dbContext) {
        try {
            $query = "SELECT * FROM currencies";
            $allCurrencies = $dbContext->getAll($query);
            $currencies = [];
            foreach ($allCurrencies as $currencyData) {
                $currency = new static($currencyData['label'], $currencyData['symbol']);
                $currencies[] = $currency->toArray();
            }
            header('Content-Type: application/json');
            return $currencies;
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch currencies: " . $e->getMessage());
        }
    }
}