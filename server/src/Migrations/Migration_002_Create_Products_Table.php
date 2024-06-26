<?php

require_once "Migration.php";

class Migration_002_Create_Products_Table extends Migration {
    public function up() {
        try {
            $sql = "
                CREATE TABLE products (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    inStock BOOLEAN,
                    description TEXT,
                    category INT,
                    brand VARCHAR(255),
                    FOREIGN KEY (category) REFERENCES categories(id) ON DELETE CASCADE
                );
            ";
            $this->conn->exec($sql);
            echo "Migration 002 executed successfully.\n";
        } catch (PDOException $e) {
            echo "Error executing migration: " . $e->getMessage() . "\n";
        }
    }
    
    public function rollback() {
        try {
            $sql = "DROP TABLE products;";
            $this->conn->exec($sql);
            echo "Rollback migration 002 executed successfully.\n";
        } catch (PDOException $e) {
            echo "Error rolling back migration: " . $e->getMessage() . "\n";
        }
    }
}