<?php

require_once __DIR__ . '/../vendor/autoload.php';

  
 
 use FastRoute\Dispatcher;
use App\Config\Database;
use App\Controller\GraphQL;
use FastRoute\RouteCollector;
use App\Database\DatabaseContext;
 
 
 
$database = new Database();

$pdo = $database->getConnection();
$databaseContext = new DatabaseContext($pdo);

$dispatcher = FastRoute\simpleDispatcher(function(RouteCollector $r) {
    $r->post('/graphql', [ GraphQL::class, 'handle']);
});

 
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