<?php

require_once './libs/request.php';
require_once './libs/response.php';

class Route {
    private $url;
    private $verb;
    private $controller;
    private $method;
    private $params;
    private $requiresAuth;

    public function __construct($url, $verb, $controller, $method, $requiresAuth = false) {
        $this->url = $url;
        $this->verb = $verb;
        $this->controller = $controller;
        $this->method = $method;
        $this->requiresAuth = $requiresAuth;
    }

    public function match($url, $verb) {
        if ($this->verb != $verb) {
            return false;
        }
        $partsURL = explode("/", trim($url, '/'));
        $partsRoute = explode("/", trim($this->url, '/'));
        if (count($partsRoute) != count($partsURL)) {
            return false;
        }
        foreach ($partsRoute as $key => $part) {
            if ($part[0] != ":") {
                if ($part != $partsURL[$key]) {
                    return false;
                }
            } else {
                $this->params[substr($part, 1)] = $partsURL[$key];
            }
        }
        return true;
    }

    public function requiresAuth() {
        return $this->requiresAuth;
    }

    public function run($request, $response) {
        $controller = $this->controller;
        $method = $this->method;
        $request->params = (object) $this->params;

        (new $controller())->$method($request, $response);
    }
}

class Router {
    private $routeTable = [];
    private $middlewares = [];
    private $request;
    private $response;


    public function __construct() {
        $this->request = new Request();
        $this->response = new Response();
    }

    public function route($url, $verb) {
        foreach ($this->routeTable as $route) {
            if ($route->match($url, $verb)) {
                // Solo ejecutar el middleware si la ruta requiere autenticación
                if ($route->requiresAuth()) {
                    foreach ($this->middlewares as $middleware) {
                        $middleware->run($this->request, $this->response);
                    }
                }
                $route->run($this->request, $this->response);
                return;
            }
        }
        // Respuesta 404 si no se encuentra la ruta
        http_response_code(404);
        echo json_encode(["message" => "Ruta no encontrada"]);
    }

    public function addMiddleware($middleware) {
        $this->middlewares[] = $middleware;
    }

    public function addRoute($url, $verb, $controller, $method, $requiresAuth = false) {
        $this->routeTable[] = new Route($url, $verb, $controller, $method, $requiresAuth);
    }
    
}
