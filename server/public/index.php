<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Config/Database.php';

use App\Config\Database;
use FastRoute\Dispatcher;
use App\Controller\GraphQL;
use FastRoute\RouteCollector;
use App\Database\DatabaseContext;
use App\Resolvers\ProductResolver;
use App\Resolvers\CategoriesResolver;

$database = new Database();
$pdo = $database->getConnection();
$databaseContext = new DatabaseContext($pdo);
$productResolver= new ProductResolver($databaseContext);
$categoriesReslover = new CategoriesResolver($databaseContext);
$graphql = new GraphQL($productResolver, $categoriesReslover);

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(204);  
    exit;
}

$dispatcher = FastRoute\simpleDispatcher(function(RouteCollector $r) use ($graphql) {
    $r->post('/graphql', [$graphql, 'handle']);
    $r->get('/test', [$graphql, "getTest"]);
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
                echo call_user_func($handler, $vars);  
                break;
            }