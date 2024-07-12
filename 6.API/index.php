<?php

declare(strict_types = 1);


require 'routes/router.php';
require 'controllers/Controller.php';
require 'controllers/ControllerKey.php';

$router = new Router();

// Define routes
$router->addRoute('GET', '/posts/{apiKey}', [new Controller(), 'posts']);
$router->addRoute('GET', '/post/{apiKey}/{id}', [new Controller(), 'postId']);
$router->addRoute('POST', '/post/{apiKey}', [new Controller(), 'createPost']);
$router->addRoute('PUT', '/post/{apiKey}/{id}', [new Controller(), 'updater']);
$router->addRoute('DELETE', '/post/{apiKey}/{id}', [new Controller(), 'delete']);

//connect user
$router->addRoute('POST', '/APIuser', [new ControllerKey(), 'connectUser']);
//test generate key
$router->addRoute('GET', '/APIkey', [new ControllerKey(), 'generate']);
//test key
$router->addRoute('GET', '/API/{apiKey}', function($apiKey) {
    $controller = new ControllerKey();
    if ($controller->connectApi($apiKey)) {
        echo "true"; // Clé API valide
    } else {
        echo "false"; // Clé API invalide
    }
});


//test
$router->addRoute('GET', '/posts/{apiKey}/{page}/{limit}', [new Controller(), 'postsPage']);




// Run the router
$router->run();

