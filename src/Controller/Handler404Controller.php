<?php
namespace App\Controller;

use App\Controller\BaseController;


class Handler404Controller extends BaseController {

    public function get(): void {
        http_response_code(400);
        require __DIR__ . '/../View/handler404.php';
    }

}