<?php 

use App\Migrations\Migration;
  
 

class Migration_008_Create_Order_Table extends Migration {





     public function up(){
        try {
           $sql = "
            CREATE TABLE orders (
                id INT AUTO_INCREMENT PRIMARY KEY,
                product_id INT,
                FOREGIN KEY (product_id) REFERENCES products(id)
                );
           ";


        } catch (PDOException $e) {
            echo "Error executing migration: " . $e->getMessage() . "\n";

        }
     }

     public function down() {
        try {
            $sql = "DROP TABLE Order;";
            $this->conn->exec($sql);
            echo "Rollback  Migration_008_Create_Order_Table executed successfully";
            
        } catch(PDOException $e) {
            echo "Error rolling back migration: " . $e->getMessage() . "\n";
        }
    }
}