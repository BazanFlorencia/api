<?php
require_once './libs/router.php';
require_once './app/controllers/products-api.controller.php';

$router = new Router();

$router->addRoute('products', 'GET', 'ProductsApiController', 'getProducts');
$router->addRoute('products/:ID', 'GET', 'ProductsApiController', 'getProduct');
$router->addRoute('products/:ID', 'DELETE', 'ProductsApiController', 'deleteProduct');
$router->addRoute('products', 'POST', 'ProductsApiController', 'insertProduct'); 


// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);

