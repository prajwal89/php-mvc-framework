<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Application;
use App\Controllers\ContactController;
use App\Controllers\ArticleController;

$app = new Application();

$app->router->get('/', 'home');

$app->router->get('/contact', [ContactController::class, 'getPage']);
$app->router->post('/contact', [ContactController::class, 'submit']);

$app->router->get('/admin/dashboard', function () {
    return view('admin.dashboard')->render();
});

$app->router->get('/article/{slug}', [ArticleController::class, 'index']);

$app->run();
