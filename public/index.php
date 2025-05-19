<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/config.php';

use App\Controller\AboutController;
use App\Controller\HomeController;
use App\Controller\BaseController;
use App\Controller\Handler404Controller;
use App\Controller\LoginController;
use App\Controller\LogoutController;
use App\Controller\RegisterController;
use App\Controller\ProfileController;
use App\Controller\FreelanceCreateController;
use App\Controller\FreelanceDetailController;
use App\Controller\ProposalCreateController;

session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$homeController = new HomeController();
$aboutController = new AboutController();
$handler404Controller = new Handler404Controller();

$loginController = new LoginController($pdo);
$registerController = new RegisterController($pdo);
$logoutController = new LogoutController();

$profileController = new ProfileController($pdo, $handler404Controller);
$freelanceCreateController = new FreelanceCreateController($pdo);
$freelanceDetailController = new FreelanceDetailController($pdo, $handler404Controller);
$proposalCreateController = new ProposalCreateController($pdo, $handler404Controller);


if ($method === 'GET') {

    if ($uri === '/') {
        BaseController::redirect('/home');

    } elseif ($uri === '/home') {
        $homeController->get();

    } elseif ($uri === '/about') {
        $aboutController->get();
        
    } elseif ($uri === '/login') {
        $loginController->get();

    } elseif ($uri === '/register') {
        $registerController->get();
    
    } elseif ($uri === '/profile') {
        $profileController->get();
        
    } elseif ($uri === '/freelance/create') {
        $freelanceCreateController->get();
        
    } elseif (preg_match('#^/freelance/(\d+)$#', $uri, $matches)) {
        $freelanceId = (int) $matches[1];
        $freelanceDetailController->get($freelanceId);

    } else {
        $handler404Controller->get();
        
    }

} elseif ($method === 'POST') {

    if ($uri === '/register') {
        $registerController->post();

    } elseif ($uri === '/login') {
        $loginController->post();
        
    } elseif ($uri === '/logout') {
        $logoutController->post();

    } elseif ($uri === '/profile/update') {
        $profileController->post();
        
    } elseif ($uri === '/freelance/create') {
        $freelanceCreateController->post();

    } elseif (preg_match('#^/freelance/(\d+)/proposal$#', $uri, $matches)) {
        $freelanceId = (int) $matches[1];
        $proposalCreateController->post($freelanceId);

    }
} 
