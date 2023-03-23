<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Application;

$app = new Application();

$app->router->get('/home', 'home');

$app->router->get('/contact', function () {
    return view('contact')->with('foo', 'bar')->render();
});

$app->router->get('/admin/dashboard', function () {
    return view('admin/dashboard')->render();
});

$app->router->get('/about-us', function () {
    echo 'about us';
});

$app->router->post('/about-us', function () {
    echo 'post about us';
});



$app->run();
