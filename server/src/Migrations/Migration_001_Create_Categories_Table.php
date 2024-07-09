<?php

use App\Migrations\Migration;



class Migration_001_Create_Categories_Table extends Migration {
    
    public function  up() {
        try {
            $sql = "
                CREATE TABLE categories (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL
                );
            ";
            
            $this->conn->exec($sql);
            echo "Migration 001 executed successfully.\n";
        } catch(PDOException $e) {
            echo "Error executing migration: " . $e->getMessage() . "\n";
        }
    }
    
    public function rollback() {
        try {
            $sql = "DROP TABLE categories;";
            $this->conn->exec($sql);
            echo "Rollback migration 001 executed successfully.\n";
        } catch(PDOException $e) {
            echo "Error rolling back migration: " . $e->getMessage() . "\n";
        }
    }
}
?>