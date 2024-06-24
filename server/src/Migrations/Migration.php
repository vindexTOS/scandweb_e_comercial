<?php

require_once __DIR__ . '/../../config/Database.php';

class Migration {
    protected $conn;
    
    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }
}
?>