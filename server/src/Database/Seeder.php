<?php

// require 'vendor/autoload.php';
require_once __DIR__ . '/../../vendor/autoload.php';


use App\Config\Database;
require_once __DIR__ . '/../../Config/Database.php';

use Faker\Factory as Faker;

class Seeder {
    private $conn;
    private $faker;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->faker = Faker::create();
    }
    
    public function seedCategories($count = 10) {
        for ($i = 0; $i < $count; $i++) {
            $sql = "INSERT INTO categories (name) VALUES (:name)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                'name' => $this->faker->word
            ]);
        }
    }
    
    
    public function seedProducts($count = 10) {
        for ($i = 0; $i < $count; $i++) {
            $sql = "INSERT INTO products (name,graphqlId, inStock, description, category, brand) VALUES (:name,:graphqlId,:inStock, :description, :category, :brand)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                'name' => $this->faker->word,
                "graphqlId"=> $this->faker->word . $this->faker->word, 
                'inStock' => 0,
                'description' => $this->faker->word,
                'category' => $this->faker->numberBetween(1, 2),  
                'brand' => $this->faker->company
            ]);
        }
    }
    public function seedAttrabutesSet($count = 10){
        for($i = 0; $i < $count;$i++){
            $sql = "INSERT INTO attribute_set (displayValue, value , attribute_id) VALUES (:displayValue, :value , :attribute_id)";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                "displayValue"=>$this->faker->word,
                "value"=>$this->faker->word,
                "attribute_id"=>$this->faker->numberBetween(1, 2)
                
            ]);};
        }
        public function seedAttrabutes($count = 20){
            for($i = 0; $i < $count;$i++){
                $sql = "INSERT INTO attribute (name, type , product_id) VALUES (:name, :type ,  :product_id)";
                
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    "name"=>$this->faker->word,
                    "type"=>$this->faker->word,
                    "product_id"=>$this->faker->numberBetween(1, 2)
                    
                ]);};
                
                
            }
            
            public function seedGallery($count = 10){
                for($i = 0; $i < $count;$i++){
                    $sql = "INSERT INTO gallery  (url, product_id) VALUES (:url ,:product_id)";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute([
                        "url"=>"https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_2_720x.jpg?v=1612816087",
                        "product_id"=>$this->faker->numberBetween(1, 2)
                        
                    ]);
                }
            }
            
            public function seedCurrency($count  = 10 ){
                for($i = 0; $i < $count;$i ++){
                    $sql = "INSERT INTO currencies (label, symbol) VALUES (:label, :symbol)";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute([ 
                        "label"=> $this->faker->word,
                        "symbol"=>$this->faker->word,
                        
                    ]);
                }
            }
            
            public function seedPrice($count = 10){
                
                for($i = 0; $i < $count ; $i ++){
                    $sql = 'INSERT INTO prices (amount , currency_id , product_id) VALUES (:amount, :currency_id,:product_id)';
                    
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute([
                        "amount"=>$this->faker->numberBetween(1, 10),  
                        "currency_id"=>$this->faker->numberBetween(1, 2),  
                        "product_id"=>$this->faker->numberBetween(1, 2)
                    ]);
                }
            }
            
            public function seed() {
                $this->seedCategories();
                $this->seedProducts();
                $this->seedCurrency();    
                $this->seedAttrabutes();
                $this->seedGallery();
                $this->seedPrice();
                $this->seedAttrabutesSet();
                echo "SEEDING HAS BEEN COMPLITED...";
            }
        }
        
        $seeder = new Seeder();
        $seeder->seed();
        ?>