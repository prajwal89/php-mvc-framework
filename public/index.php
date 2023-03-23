<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Application;

$app = new Application();

$app->router->get('/contact', function () {
    echo 'contact';
});

$app->router->get('/about-us', function () {
    echo 'about us';
});

$app->router->post('/about-us', function () {
    echo 'post about us';
});



$app->run();
