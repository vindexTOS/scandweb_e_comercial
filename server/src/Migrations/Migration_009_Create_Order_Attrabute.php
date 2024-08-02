<?php 


use App\Migrations\Migration;


class Migration_009_Create_Order_Attrabute extends Migration {





     public function up(){
        try {
           $sql = "
            CREATE TABLE order_attrabute (
                id INT AUTO_INCREMENT PRIMARY KEY,
                 key  VARCHAR(225) NOT NULL,
                 value  VARCHAR(225) NOT NULL,
                order_id INT,
                FOREGIN KEY (order_id ) REFERENCES orders(id)
 

            );
           ";
        } catch (PDOException $e) {
            echo "Error executing migration: " . $e->getMessage() . "\n";

        }
     }



     public function down() {
        try {
            $sql = "DROP TABLE order_attrabute;";
            $this->conn->exec($sql);
            echo "Rollback  Migration_009_Create_Order_Attrabute executed successfully";
            
        } catch(PDOException $e) {
            echo "Error rolling back migration: " . $e->getMessage() . "\n";
        }
    }
}