<?php

class Router
{
    private array $routes = [];

    public function get(string $uri, array $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post(string $uri, array $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

  public function dispatch()
{
    $method = $_SERVER['REQUEST_METHOD'];

    // Full request URI
    $uri = $_SERVER['REQUEST_URI'];

    // Remove query string
    if (($pos = strpos($uri, '?')) !== false) {
        $uri = substr($uri, 0, $pos);
    }

    // Project base path
    $basePath = '/habitract_webapp/public';

    // Remove base path
    if (strpos($uri, $basePath) === 0) {
        $uri = substr($uri, strlen($basePath));
    }

    // Remove index.php
    if (strpos($uri, '/index.php') === 0) {
        $uri = substr($uri, strlen('/index.php'));
    }

    // Normalize empty URI
    if ($uri === '') {
        $uri = '/login';
    }

    // DEBUG (temporary – keep for now)
    // echo "ROUTER HIT: [$method] $uri"; exit;

    if (isset($this->routes[$method][$uri])) {
        [$controller, $methodName] = $this->routes[$method][$uri];
        call_user_func([new $controller, $methodName]);
        return;
    }

    http_response_code(404);
    echo '404 - Route not found';
}
}