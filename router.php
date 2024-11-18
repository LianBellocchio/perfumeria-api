<?php

require_once 'libs/router.php';
require_once 'app/controllers/CategoriaApiController.php';
require_once 'app/controllers/ProductoApiController.php';
require_once 'app/controllers/IngredienteApiController.php';
require_once 'app/controllers/AuthController.php';
require_once 'app/middlewares/jwt.auth.middleware.php';

$router = new Router();

// Agregar el middleware de JWT
$router->addMiddleware(new JWTAuthMiddleware());

// Rutas sin autenticación
$router->addRoute('login', 'POST', 'AuthController', 'login');


// Definir rutas para la API REST

// Rutas para Categorías
$router->addRoute('categorias', 'GET', 'CategoriaApiController', 'getAll');
$router->addRoute('categorias/:id', 'GET', 'CategoriaApiController', 'get');
$router->addRoute('categorias', 'POST', 'CategoriaApiController', 'create', true);
$router->addRoute('categorias/:id', 'PUT', 'CategoriaApiController', 'update', true);
$router->addRoute('categorias/:id', 'DELETE', 'CategoriaApiController', 'delete', true);

// Rutas para Productos
$router->addRoute('productos', 'GET', 'ProductoApiController', 'getAll');
$router->addRoute('productos/:id', 'GET', 'ProductoApiController', 'get');
$router->addRoute('productos', 'POST', 'ProductoApiController', 'create', true);
$router->addRoute('productos/:id', 'PUT', 'ProductoApiController', 'update', true);
$router->addRoute('productos/:id', 'DELETE', 'ProductoApiController', 'delete', true);

// Rutas para Ingredientes
$router->addRoute('ingredientes', 'GET', 'IngredienteApiController', 'getAll');
$router->addRoute('ingredientes/:id', 'GET', 'IngredienteApiController', 'get');
$router->addRoute('ingredientes', 'POST', 'IngredienteApiController', 'create', true);
$router->addRoute('ingredientes/:id', 'PUT', 'IngredienteApiController', 'update', true);
$router->addRoute('ingredientes/:id', 'DELETE', 'IngredienteApiController', 'delete', true);

// Ejecutar el enrutador
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
?>
