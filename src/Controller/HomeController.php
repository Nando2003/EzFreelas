<?php
namespace App\Controller;

use App\Controller\BaseController;


class HomeController extends BaseController {

    public function get(): void {
        require __DIR__ . '/../View/home.php';
    }

}