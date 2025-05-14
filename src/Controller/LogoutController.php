<?php
namespace App\Controller;

use App\Controller\BaseController;


class LogoutController extends BaseController {

    public function get(): void {
        $this->redirect('/home');
    }

    public function post(): void {
        unset($_SESSION['user_id']);
        $_SESSION['flash_alert'] = "Usuário desconectado com sucesso";

        $this->redirect('/home');
    }
    
}