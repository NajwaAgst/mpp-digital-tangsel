<?php

namespace App\Bootstrap;

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

require __DIR__ . '/../routes/web.php';

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\InteroperabilityController;

class App
{
    public function run(): void
    {
        session_start();
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $routes = require __DIR__ . '/../routes/web.php';

        foreach ($routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $pattern = str_replace('/', '\/', $route['uri']);
            $pattern = preg_replace('/\{([a-zA-Z0-9_-]+)\}/', '([^/]+)', $pattern);
            if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                $controller = new $route['controller']();
                $params = array_slice($matches, 1);
                $response = call_user_func_array([$controller, $route['action']], $params);
                echo $response;
                return;
            }
        }

        http_response_code(404);
        echo '404 Not Found';
    }
}
