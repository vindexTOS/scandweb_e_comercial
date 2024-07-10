<?php

use App\Migrations\Migration;



class Migration_007_Create_Attribute_Set_Table extends Migration {
    
    
    
    
    public function up(){
        try {
            $sql = "
                CREATE TABLE attribute_set (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    displayValue VARCHAR(255) NOT NULL,
                    value VARCHAR(255) NOT NULL,
                  attribute_id INT,
               FOREIGN KEY ( attribute_id) REFERENCES attribute(id)
                );
            ";
            $this->conn->exec($sql);
            
            echo "Migration 007 executed successfully";
            
        } catch (PDOException $e) {
            echo "Error executing migration: " . $e->getMessage() . "\n";
            
        }
    }
    public function down() {
        try {
            $sql = "DROP TABLE attribute_set;";
            $this->conn->exec($sql);
            echo "Rollback migration 007 executed successfully";
            
        } catch(PDOException $e) {
            echo "Error rolling back migration: " . $e->getMessage() . "\n";
        }
    }
    
}