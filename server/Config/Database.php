<?php

namespace App\Config;

use PDO;
use PDOException;

class Database {
    private $host = "127.0.0.1";
    private $db_name = "scandiweb";
    private $username = "eideasMySql";
    private $password = "WdvgY159753ZxC";
    private $conn;
    
    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->createDatabaseIfNotExists();
            $this->conn->exec("USE " . $this->db_name);
            $this->conn->exec("set names utf8");
        } catch(PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
    }
    
    private function createDatabaseIfNotExists() {
        try {
            $sql = "CREATE DATABASE IF NOT EXISTS $this->db_name";
            $this->conn->exec($sql);
            // echo "Database '$this->db_name' created successfully or already exists.\n";
        } catch(PDOException $e) {
            echo "Error creating database: " . $e->getMessage();
            throw $e;
        }
    }
    
    public function getConnection() {
        return $this->conn;
    }
}
?>
