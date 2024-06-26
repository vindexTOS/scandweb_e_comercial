<?php 

require_once "Migration.php";

class Migration_005_Create_AttributeSet_Table extends Migration {
    
    public function up() {
        try {
            $sql = "
                CREATE TABLE attribute_set (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    type VARCHAR(255) NOT NULL
                );
            ";
            
            $this->conn->exec($sql);
            echo "Migration 005 executed successfully";
            
        } catch(PDOException $e) {
            echo "Error executing migration: " . $e->getMessage() . "\n";
        }
    }
    
    public function down() {
        try {
            $sql = "DROP TABLE attribute_set;";
            $this->conn->exec($sql);
            echo "Rollback migration 005 executed successfully";
            
        } catch(PDOException $e) {
            echo "Error rolling back migration: " . $e->getMessage() . "\n";
        }
    }
}