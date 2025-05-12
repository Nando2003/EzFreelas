<?php
namespace App\Controller;


class HomeController {
    public function gotoHome(): void {
        header('Location: /home');
        exit;
    }

    public function showHome(): void {
        require __DIR__ . '/../View/home/home.php';
    }

    public function showAbout(): void {
        require __DIR__ . '/../View/home/about.php';
    }
}