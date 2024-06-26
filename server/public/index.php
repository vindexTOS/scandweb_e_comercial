<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php'; // Adjust the path to your database.php file

use App\Config\Database;
use FastRoute\RouteCollector;
use FastRoute\Dispatcher;

// Initialize database connection
$database = new Database();
$pdo = $database->getConnection();

$dispatcher = FastRoute\simpleDispatcher(function(RouteCollector $r) {
    $r->post('/graphql', [App\Controller\GraphQL::class, 'handle']);
});

// Handle routing
$routeInfo = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo json_encode(['error' => 'Route not found']);
        break;
        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            $allowedMethods = $routeInfo[1];
            echo json_encode(['error' => 'Method not allowed']);
            break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                echo call_user_func([new $handler[0], $handler[1]], $vars);
                break;
            }