<?php

namespace App\Database;

use PDO;
use PDOException;
use RuntimeException;

class DatabaseContext {
    private ?PDO $conn ;
    
    public function __construct(?PDO $conn = null) {
        $this->conn = $conn;
    }
    
    
    public function getAll(string $query, array $params = []): array {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to execute query: " . $e->getMessage());
        }
    }
    public function getSingleById(string $table, string $id): array {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM $table WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch data from $table: " . $e->getMessage());
        }
    }
    
    
}