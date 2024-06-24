<?php
require_once __DIR__ . '/../../config/Database.php';

// Define migrations to be executed
$migrations = [
    __DIR__ . DIRECTORY_SEPARATOR . "Migration_001_Create_Categories_Table.php",
    // Add other migration files here as needed
];

try {
    // Establish database connection (Database constructor handles database creation if needed)
    $database = new \App\Config\Database();
    $conn = $database->getConnection();
    
    // Loop through migrations and execute each one
    foreach ($migrations as $migrationFile) {
        if (file_exists($migrationFile)) {
            require_once $migrationFile;
            $className = basename($migrationFile, '.php');
            if (class_exists($className)) {
                $migration = new $className($conn);
                $migration->up();  // Assuming you're running the 'up' method of each migration
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