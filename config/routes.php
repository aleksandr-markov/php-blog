<?php

/**
 * @var Application $app
 **/


use App\Controllers\HomeController;
use App\Controllers\UserController;
use PHPFramework\Application;
use PHPFramework\Middleware\Auth;
use PHPFramework\Middleware\Guest;

const MIDDLEWARE = [
    'auth' => Auth::class,
    'guest' => Guest::class
];



$app->router->get('/', [HomeController::class, 'index']);
$app->router->get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth']);
$app->router->get('/register', [UserController::class, 'register'])->middleware(['guest']);
$app->router->post('/register', [UserController::class, 'store'])->middleware(['guest']);
$app->router->get('/logout', [UserController::class, 'logout'])->middleware(['auth']);
$app->router->get('/login', [UserController::class, 'login'])->middleware(['guest']);
$app->router->post('/login', [UserController::class, 'auth'])->middleware(['guest']);






//$app->router->get('/post/(?P<slug>[a-z0-9-]+)/?', function () {
//    return 'post';
//});
