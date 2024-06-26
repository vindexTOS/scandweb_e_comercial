<?php 

require_once "Migration.php";

class Migration_006_Create_Attribute_Table extends Migration {
    
    public function up() {
        try {
            $sql = "
                CREATE TABLE attribute (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    displayValue VARCHAR(255) NOT NULL,
                    value VARCHAR(255) NOT NULL,
                    attributeSet_id INT,
                    FOREIGN KEY (attributeSet_id) REFERENCES attribute_set(id)
                );
            ";
            
            $this->conn->exec($sql);
            
            echo "Migration 006 executed successfully";
            
        } catch(PDOException $e) {
            echo "Error executing migration: " . $e->getMessage() . "\n";
        }
    }
    
    public function down() {
        try {
            $sql = "DROP TABLE attribute;";
            $this->conn->exec($sql);
            echo "Rollback migration 006 executed successfully";
            
        } catch(PDOException $e) {
            echo "Error rolling back migration: " . $e->getMessage() . "\n";
        }
    }
}