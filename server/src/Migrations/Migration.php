<?php

// require_once __DIR__ . '/../../Config/Database.php';
namespace App\Migrations;
require 'vendor/autoload.php';


use PDO;

class Migration {
    protected $conn;
    
    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }
}
?>