<?php

use App\Migrations\Migration;

 
class Migration_006_Create_Price_Table extends Migration {
    public function up() {
        try {
            $sql = "
                CREATE TABLE prices (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    amount DECIMAL(10, 2) NOT NULL,
                    currency_id INT,
                    product_id INT,
                    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
                    FOREIGN KEY (currency_id) REFERENCES currencies(id) ON DELETE CASCADE
                );
            ";
            $this->conn->exec($sql);
            echo "Migration 006 executed successfully.\n";
        } catch (PDOException $e) {
            echo "Error executing migration: " . $e->getMessage() . "\n";
        }
    }
    
    public function rollback() {
        try {
            $sql = "DROP TABLE prices;";
            $this->conn->exec($sql);
            echo "Rollback migration 006 executed successfully.\n";
        } catch (PDOException $e) {
            echo "Error rolling back migration: " . $e->getMessage() . "\n";
        }
    }
}