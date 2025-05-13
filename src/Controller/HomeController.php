<?php
namespace App\Controller;


class HomeController {
    public function gotoHome(): void {
        header('Location: /home');
        exit;
    }

    public function getHome(): void {
        require __DIR__ . '/../View/home/home.php';
    }

    public function getAbout(): void {
        require __DIR__ . '/../View/home/about.php';
    }

    public static function getHandler404(): void {
        http_response_code(400);
        require __DIR__ . '/../View/errors/handler404.php';
    }
}