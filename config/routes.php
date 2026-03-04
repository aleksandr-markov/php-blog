<?php

/**
 * @var \PHPFramework\Application $app
 **/


$app->router->get('/', [\App\Controllers\HomeController::class, 'index']);

$app->router->get('/register', [\App\Controllers\UserController::class, 'register']);
$app->router->get('/login', [\App\Controllers\UserController::class, 'login']);

$app->router->post('/store', [\App\Controllers\UserController::class, 'store']);






//$app->router->get('/post/(?P<slug>[a-z0-9-]+)/?', function () {
//    return 'post';
//});
