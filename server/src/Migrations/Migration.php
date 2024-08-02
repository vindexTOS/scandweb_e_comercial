<?php

namespace App\Migrations;
// require_once __DIR__ . '/../../Config/Database.php';

// require 'vendor/autoload.php';


use PDO;

class Migration {
    protected $conn;
    
    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }
}
 