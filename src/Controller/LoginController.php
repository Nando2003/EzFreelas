<?php
namespace App\Controller;

use PDO;
use App\Repository\UserRepository;
use App\Controller\BaseController;


class LoginController extends BaseController{
    private UserRepository $userRepository;

    public function __construct(PDO $pdo) {
        $this->userRepository = new UserRepository($pdo);
    }

    public function get(?string $error = null): void {
        if ($this->getUserId() != null) {
            $this->redirect('/home');
            return;
        }

        require __DIR__ . '/../View/auth/login.php';
    }

    public function post(): void {
        if ($this->getUserId() != null) {
            $this->redirect('/home');
            return;
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $error_message = "Usuário ou senha incorretos";

        $user = $this->userRepository->findByUsername($username);
        
        if (!$user) {
            $this->get($error_message);
            return;
        }

        if (! password_verify($password, $user->getPassword())) {
            $this->get($error_message);
            return;
        }

        $_SESSION['user_id'] = $user->getId();
        $_SESSION['flash_success'] = "Usuário conectado com sucesso";

        $this->redirect('/home');
    }
}