<?php

declare(strict_types = 1);

require 'router.php';
require 'Controller/HomepageController.php';
require 'Controller/ArticleController.php';

$router = new Router();

// Define routes
$router->addRoute('GET', '/', [new HomepageController(), 'index']);
$router->addRoute('GET', '/articles', [new ArticleController(), 'index']);
$router->addRoute('GET', '/articles/id={id}', [new ArticleController(), 'show']);
$router->addRoute('GET', '/author_id={id}', [new ArticleController(), 'author']);

// Run the router
$router->run();
