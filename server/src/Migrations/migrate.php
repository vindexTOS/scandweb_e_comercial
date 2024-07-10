<?php

use App\Config\Database;
// require 'vendor/autoload.php';   // linxu sverison 
require_once __DIR__ . '/../../vendor/autoload.php';

require_once __DIR__ . '/../../Config/Database.php';

$migrations = [
    __DIR__ . DIRECTORY_SEPARATOR . "Migration_001_Create_Categories_Table.php",
    __DIR__ . DIRECTORY_SEPARATOR . "Migration_002_Create_Products_Table.php",
    
    __DIR__ . DIRECTORY_SEPARATOR . "Migration_003_Create_Gallery_Table.php",
    __DIR__ . DIRECTORY_SEPARATOR . "Migration_004_Create_Currencies_Table.php",
    __DIR__ . DIRECTORY_SEPARATOR . "Migration_005_Create_Attribute_Table.php",
    __DIR__ . DIRECTORY_SEPARATOR . "Migration_006_Create_Price_Table.php",
    __DIR__ . DIRECTORY_SEPARATOR . "Migration_007_Create_Attribute_Set_Table.php",
    
    
    
    
    
];

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    foreach ($migrations as $migrationFile) {
        if (file_exists($migrationFile)) {
            require_once $migrationFile;
            $className = basename($migrationFile, '.php');
            if (class_exists($className)) {
                $migration = new $className($conn);
                $migration->up();  
                echo "Executed migration: $className\n";
            } else {
                echo "Migration class $className not found in $migrationFile\n";
            }
        } else {
            echo "Migration file $migrationFile not found\n";
        }
    }
} catch (PDOException $e) {
    echo "PDO Connection failed: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "Error executing migration: " . $e->getMessage() . "\n";
}
?>

