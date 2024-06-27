<?php

require_once "Migration.php";

class Migration_004_Create_Currencies_Table extends Migration {
    
    public function up() {
        try {
            $sql = "
                CREATE TABLE IF NOT EXISTS currencies (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    label VARCHAR(255) NOT NULL,
                    symbol VARCHAR(255) NOT NULL
                );
            ";
            $this->conn->exec($sql);
            echo "Migration 004 for currencies executed successfully.\n";
        } catch(PDOException $e) {
            echo "Error executing migration: " . $e->getMessage() . "\n";
        }
    }
    
    public function down() {
        try {
            $sql = "DROP TABLE IF EXISTS currencies;";
            $this->conn->exec($sql);
            echo "Rollback migration 004 for currencies executed successfully.\n";
        } catch(PDOException $e) {
            echo "Error rolling back migration: " . $e->getMessage() . "\n";
        }
    }
}
?>