<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Application;
use App\Controllers\ContactController;
use App\Controllers\BlogController;
use App\Controllers\AuthController;

$app = new Application();

$app->router->get('/',  function () {
    return view('home')->layout('layouts.app')->render();
});

$app->router->match(['get', 'post'], '/login', [AuthController::class, 'loginPage']);
$app->router->match(['get', 'post'], '/register', [AuthController::class, 'registerPage']);

$app->router->get('/contact', [ContactController::class, 'getPage']);
$app->router->post('/contact', [ContactController::class, 'submit']);


$app->router->get('/blog/{slug}', [BlogController::class, 'index']);

$app->run();
