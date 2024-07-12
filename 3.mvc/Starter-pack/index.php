<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//include all your model files here
require 'Model/Article.php';
//include all your controllers here
require 'Controller/HomepageController.php';
require 'Controller/ArticleController.php';

// Get the current page to load
// If nothing is specified, it will remain empty (home should be loaded)
$page = $_GET['page'] ?? null;
$id = $_GET['id'] ?? null;
$author_id = $_GET['author_id'] ?? null;

// Load the controller
// It will *control* the rest of the work to load the page
switch ($page) {
    case 'articles-index':
        // This is shorthand for:
        // $articleController = new ArticleController;
        // $articleController->index();
        (new ArticleController())->index();
        break;
    case 'articles-show':
        if ($id !== null) {
            (new ArticleController())->show((int)$id);
        } else {
            echo "<a href='index.php'>Home</a> <br> Article ID not provided.";
        }
        break;
    case 'articles-author':
        if ($author_id !== null) {
            (new ArticleController())->author((int)$author_id);
        } else {
            echo "<a href='index.php'>Home</a> <br> Author ID not provided.";
        }
        break;
    case 'home':
    default:
        (new HomepageController())->index();
        break;
}