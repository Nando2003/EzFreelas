<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/config.php';

use App\Controller\HomeController;
use App\Controller\UserController;
use App\Controller\FreelanceController;

session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$homeController = new HomeController();
$userController = new UserController($pdo, fn() => $homeController->gotoHome());
$freelanceController = new FreelanceController($pdo , fn() => $userController->gotoLoginForm());

if ($method === 'GET') {

    if ($uri === '/') {
        $homeController->gotoHome();

    } elseif ($uri === '/home') {
        $homeController->getHome();

    } elseif ($uri === '/about') {
        $homeController->getAbout();
        
    } elseif ($uri === '/login') {
        $userController->getLoginForm();

    } elseif ($uri === '/register') {
        $userController->getRegisterForm();
    
    } elseif ($uri === '/freelance') {
        $freelanceController->getFreelances();
    
    } elseif (preg_match('#^/freelance/(\d+)$#', $uri, $matches)) {
        $freelanceId = (int)$matches[1];
        $freelanceController->getFreelance($freelanceId);
    
    } elseif ($uri === '/freelance/create') {
        $freelanceController->getFreelanceForm();
    
    } else {
        $homeController->getHandler404();
    }

} elseif ($method === 'POST') {

    if ($uri === '/register') {
        $userController->postRegisterForm();

    } elseif ($uri === '/login') {
        $userController->postLoginForm();
        
    } elseif ($uri === '/logout') {
        $userController->postLogout();

    } 
} 

