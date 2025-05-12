<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/config.php';

use App\Controller\HomeController;
use App\Controller\UserController;

session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$homeController = new HomeController();
$userController = new UserController($pdo);

if ($method === 'GET') {

    if ($uri === '/') {
        $homeController->gotoHome();

    } elseif ($uri === '/home') {
        $homeController->showHome();

    } elseif ($uri === '/about') {
        $homeController->showAbout();
        
    } elseif ($uri === '/login') {
        $userController->showLoginForm();

    } elseif ($uri === '/register') {
        $userController->showRegisterForm();

    } else {
        http_response_code(404);
        require __DIR__ . '/../src/View/errors/handler404.php';
        exit;
    }

} elseif ($method === 'POST') {

    if ($uri === '/register') {
        $userController->register();

    } elseif ($uri === '/logout') {
        $userController->logout();

    } elseif ($uri === '/login') {
        $userController->login();
        
    }

    else {
        http_response_code(404);
        require __DIR__ . '/../src/View/errors/handler404.php';
        exit;
    }

} 

