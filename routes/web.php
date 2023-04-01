<?php

use App\Controllers\AuthController;
use App\Controllers\BlogController;
use App\Controllers\ContactController;
use App\Controllers\UserController;
use App\Core\Application;

$app = new Application();


$app->router->get('/',  function () {
    return view('home')->layout('layouts.app')->render();
});

$app->router->match(['get', 'post'], '/login', [AuthController::class, 'loginPage']);
$app->router->match(['get', 'post'], '/register', [AuthController::class, 'registerPage']);

$app->router->get('/contact', [ContactController::class, 'getPage']);
$app->router->post('/contact', [ContactController::class, 'submit']);

$app->router->get('/blog/{slug}', [BlogController::class, 'index']);

$app->router->middleware('auth')->get('/user/dashboard', [UserController::class, 'dashboard']);

$app->run();
