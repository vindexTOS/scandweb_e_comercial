<?php

use App\Migrations\Migration;
 

class Migration_003_Create_Gallery_Table extends Migration {
    
    
    
    public function up(){
        
        try {
            $sql = "
             CREATE TABLE gallery (
             id INT AUTO_INCREMENT PRIMARY KEY,
             url TEXT, 
             product_id INT,
             FOREIGN KEY (product_id)  REFERENCES products(id) ON DELETE CASCADE
             );
            ";
            $this->conn->exec($sql);
            echo "Migration 003 executed successfully.\n";
            
            
        } catch (PDOException $e) {
            echo "Error executing migration: " . $e->getMessage() . "\n";
            
        }
    }
    
    public function rollback() {
        try {
            $sql = "DROP TABLE gallery;";
            $this->conn->exec($sql);
            echo "Rollback migration 003 executed successfully.\n";
        } catch (PDOException $e) {
            echo "Error rolling back migration: " . $e->getMessage() . "\n";
        }
    }
}
