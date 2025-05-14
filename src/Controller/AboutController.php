<?php
namespace App\Controller;

use App\Controller\BaseController;


class AboutController extends BaseController {

    public function get(): void {
        require __DIR__ . '/../View/home/about.php';
    }
    
}