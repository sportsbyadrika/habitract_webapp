<?php
class Router {
    private array $routes = [];

    public function get($uri, $action) {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action) {
        $this->routes['POST'][$uri] = $action;
    }

   public function dispatch() {
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // Remove project base path
    $basePath = '/habitract_webapp/public';
    if (strpos($uri, $basePath) === 0) {
        $uri = substr($uri, strlen($basePath));
    }

    // Remove index.php from URI
    if (strpos($uri, '/index.php') === 0) {
        $uri = substr($uri, strlen('/index.php'));
    }

    if ($uri === '') {
        $uri = '/login';
    }

    if (isset($this->routes[$method][$uri])) {
        [$controller, $methodName] = $this->routes[$method][$uri];
        call_user_func([new $controller, $methodName]);
    } else {
        http_response_code(404);
        echo "404 - Page Not Found";
    }
}
}